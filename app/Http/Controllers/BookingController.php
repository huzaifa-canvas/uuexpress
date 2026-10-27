<?php

namespace App\Http\Controllers;

use App\Mail\BookingReceived;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Stripe\StripeClient;

class BookingController extends Controller
{
    /**
     * Create a Stripe PaymentIntent for the chosen service's price.
     * The amount is derived server-side from the service record — never trusted from the client.
     */
    public function paymentIntent(Request $request): JsonResponse
    {
        $request->validate(['service_type' => 'required|string']);

        $service = Service::where('name', $request->service_type)->first();

        if (! $service || (float) $service->price <= 0) {
            return response()->json([
                'payable' => false,
                'message' => 'No online payment is required for this service.',
            ]);
        }

        try {
            $stripe = new StripeClient(config('services.stripe.secret'));
            $intent = $stripe->paymentIntents->create([
                'amount' => $this->cents($service->price),
                'currency' => config('services.stripe.currency', 'usd'),
                // Dynamic payment methods, but inline only (no redirect) so the
                // card element + confirmCardPayment flow keeps working.
                'automatic_payment_methods' => ['enabled' => true, 'allow_redirects' => 'never'],
                'metadata' => ['service' => $service->name],
            ]);
        } catch (\Throwable $e) {
            Log::error('Stripe PaymentIntent create failed: ' . $e->getMessage());

            return response()->json(['error' => 'Payment could not be started. Please try again.'], 422);
        }

        return response()->json([
            'payable' => true,
            'clientSecret' => $intent->client_secret,
            'amount' => (float) $service->price,
            'amount_display' => '$' . number_format($service->price, 2),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:30',
            'service_type' => 'nullable|string|max:100',
            'pickup_address' => 'required|string|max:255',
            'dropoff_address' => 'required|string|max:255',
            'pickup_date' => 'required|date_format:Y-m-d',
            'pickup_time' => 'required',
            'notes' => 'nullable|string',
        ], [
            'name.required' => 'Name is required.',
            'email.required' => 'A valid email is required.',
            'email.email' => 'A valid email is required.',
            'pickup_address.required' => 'Pickup address is required.',
            'dropoff_address.required' => 'Drop-off address is required.',
            'pickup_date.required' => 'A valid pickup date is required.',
            'pickup_date.date_format' => 'A valid pickup date is required.',
            'pickup_time.required' => 'A valid pickup time is required.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => implode(' ', $validator->errors()->all()),
            ]);
        }

        $data = $validator->validated();

        // Verify payment when the chosen service has a price.
        $service = Service::where('name', $data['service_type'] ?? '')->first();
        $data['amount'] = null;
        $data['payment_status'] = 'unpaid';
        $data['payment_intent_id'] = null;

        if ($service && (float) $service->price > 0) {
            $paymentError = $this->verifyPayment($request->input('payment_intent_id'), $service);
            if ($paymentError) {
                return response()->json(['status' => 'error', 'message' => $paymentError]);
            }
            $data['amount'] = (float) $service->price;
            $data['payment_status'] = 'paid';
            $data['payment_intent_id'] = $request->input('payment_intent_id');
        }

        $booking = Booking::create($data);

        try {
            Mail::to($this->notifyAddress())->send(new BookingReceived($booking));
        } catch (\Throwable $e) {
            Log::error('Booking notification email failed: ' . $e->getMessage());
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Thanks! Your booking request has been sent — we\'ll confirm shortly.',
        ]);
    }

    /** Returns an error string if the payment is invalid, or null when it checks out. */
    private function verifyPayment(?string $paymentIntentId, Service $service): ?string
    {
        if (! $paymentIntentId) {
            return 'Payment is required to complete this booking.';
        }

        try {
            $stripe = new StripeClient(config('services.stripe.secret'));
            $intent = $stripe->paymentIntents->retrieve($paymentIntentId);
        } catch (\Throwable $e) {
            Log::error('Stripe PaymentIntent retrieve failed: ' . $e->getMessage());

            return 'We could not verify your payment. Please try again.';
        }

        if ($intent->status !== 'succeeded') {
            return 'Your payment was not completed. Please try again.';
        }

        if ((int) $intent->amount !== $this->cents($service->price)) {
            return 'Payment amount did not match the service price.';
        }

        return null;
    }

    private function cents($price): int
    {
        return (int) round(((float) $price) * 100);
    }

    private function notifyAddress(): string
    {
        return config('mail.notify_address') ?: config('mail.from.address');
    }
}

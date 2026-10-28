<?php

namespace App\Http\Controllers;

use App\Mail\NewOrderAdmin;
use App\Mail\OrderConfirmation;
use App\Models\Order;
use App\Support\Cart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stripe\StripeClient;

class CheckoutController extends Controller
{
    public function show(Cart $cart)
    {
        if ($cart->isEmpty()) {
            return redirect()->route('shop')->with('status', 'Your cart is empty.');
        }

        return view('pages.checkout', [
            'items' => $cart->items(),
            'subtotal' => $cart->subtotal(),
        ]);
    }

    /** Create a PaymentIntent for the current cart total. */
    public function paymentIntent(Cart $cart): JsonResponse
    {
        if ($cart->isEmpty()) {
            return response()->json(['error' => 'Your cart is empty.'], 422);
        }

        try {
            $stripe = new StripeClient(config('services.stripe.secret'));
            $intent = $stripe->paymentIntents->create([
                'amount' => $this->cents($cart->subtotal()),
                'currency' => config('services.stripe.currency', 'usd'),
                'automatic_payment_methods' => ['enabled' => true, 'allow_redirects' => 'never'],
                'metadata' => ['type' => 'shop_order'],
            ]);
        } catch (\Throwable $e) {
            Log::error('Stripe checkout PaymentIntent failed: ' . $e->getMessage());

            return response()->json(['error' => 'Payment could not be started. Please try again.'], 422);
        }

        return response()->json([
            'clientSecret' => $intent->client_secret,
            'amount' => $cart->subtotal(),
            'amount_display' => '$' . number_format($cart->subtotal(), 2),
        ]);
    }

    public function store(Request $request, Cart $cart)
    {
        if ($cart->isEmpty()) {
            return redirect()->route('shop')->with('status', 'Your cart is empty.');
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:120',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:40',
            'address' => 'required|string|max:255',
            'city' => 'nullable|string|max:100',
            'postcode' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
        ]);

        $subtotal = $cart->subtotal();
        $total = $subtotal;

        $error = $this->verifyPayment($request->input('payment_intent_id'), $total);
        if ($error) {
            return back()->withInput()->withErrors(['payment' => $error]);
        }

        $cartItems = $cart->items();

        $order = DB::transaction(function () use ($validated, $subtotal, $total, $cartItems, $request) {
            $order = Order::create(array_merge($validated, [
                'order_number' => Order::generateNumber(),
                'user_id' => $request->user()?->id,
                'subtotal' => $subtotal,
                'total' => $total,
                'status' => 'processing',
                'payment_status' => 'paid',
                'payment_intent_id' => $request->input('payment_intent_id'),
            ]));

            foreach ($cartItems as $item) {
                $product = $item['product'];
                $order->items()->create([
                    'product_id' => $product->id,
                    'name' => html_entity_decode($product->name),
                    'image' => $product->image,
                    'price' => $product->price,
                    'quantity' => $item['quantity'],
                    'line_total' => $item['line_total'],
                ]);
            }

            return $order;
        });

        // WooCommerce-style notifications: one to the shop, one to the customer.
        try {
            Mail::to($this->notifyAddress())->send(new NewOrderAdmin($order));
        } catch (\Throwable $e) {
            Log::error('Order admin email failed: ' . $e->getMessage());
        }
        try {
            Mail::to($order->email)->send(new OrderConfirmation($order));
        } catch (\Throwable $e) {
            Log::error('Order customer email failed: ' . $e->getMessage());
        }

        $cart->clear();
        session()->push('my_orders', $order->id);

        return redirect()->route('checkout.received', $order);
    }

    public function received(Order $order)
    {
        abort_unless(
            in_array($order->id, session('my_orders', []), true)
            || (auth()->check() && auth()->id() === $order->user_id),
            403
        );

        $order->load('items');

        return view('pages.order-received', compact('order'));
    }

    private function verifyPayment(?string $paymentIntentId, float $total): ?string
    {
        if (! $paymentIntentId) {
            return 'Payment is required to place this order.';
        }

        try {
            $stripe = new StripeClient(config('services.stripe.secret'));
            $intent = $stripe->paymentIntents->retrieve($paymentIntentId);
        } catch (\Throwable $e) {
            Log::error('Stripe order PaymentIntent retrieve failed: ' . $e->getMessage());

            return 'We could not verify your payment. Please try again.';
        }

        if ($intent->status !== 'succeeded') {
            return 'Your payment was not completed. Please try again.';
        }

        if ((int) $intent->amount !== $this->cents($total)) {
            return 'Payment amount did not match your cart total.';
        }

        return null;
    }

    private function cents($amount): int
    {
        return (int) round(((float) $amount) * 100);
    }

    private function notifyAddress(): string
    {
        return config('mail.notify_address') ?: config('mail.from.address');
    }
}

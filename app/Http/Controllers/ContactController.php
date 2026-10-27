<?php

namespace App\Http\Controllers;

use App\Mail\ContactReceived;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        return view('pages.contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:40',
            'subject' => 'required|string|max:200',
            'message' => 'required|string',
        ]);

        $message = ContactMessage::create($validated);

        // Email the business. Non-fatal: the message is already saved.
        try {
            Mail::to($this->notifyAddress())->send(new ContactReceived($message));
        } catch (\Throwable $e) {
            Log::error('Contact notification email failed: ' . $e->getMessage());
        }

        return redirect()->route('thank-you');
    }

    private function notifyAddress(): string
    {
        return config('mail.notify_address') ?: config('mail.from.address');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

class PaymentController extends Controller
{
    public function process(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric',
            'payment_method' => 'required|string',
        ]);

        // Simulate payment processing
        // In production, integrate with Stripe/PayPal/Paymob here
        $transactionId = 'TXN-' . strtoupper(substr(md5(uniqid()), 0, 10));

        return response()->json([
            'success' => true,
            'transactionId' => $transactionId,
            'message' => 'Payment processed successfully',
        ]);
    }

    public function status($transactionId)
    {
        // In production, check actual payment gateway status
        return response()->json([
            'transactionId' => $transactionId,
            'status' => 'Paid',
        ]);
    }

    public function sendCheckoutOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $otp = rand(1000, 9999);
        $key = 'checkout_otp_' . $request->email;
        Cache::put($key, $otp, now()->addMinutes(10));

        try {
            Mail::raw("Your Kemet checkout verification code is: {$otp}\nThis code will expire in 10 minutes.", function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Checkout OTP - Kemet');
            });
        } catch (\Exception $e) {
            \Log::error("Failed to send checkout OTP: " . $e->getMessage());
            // Fallback for development if SMTP fails
            return response()->json(['message' => 'Failed to send OTP via email. Development code: ' . $otp], 500); 
        }

        return response()->json(['message' => 'OTP sent successfully']);
    }

    public function verifyCheckoutOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|numeric|digits:4'
        ]);

        $key = 'checkout_otp_' . $request->email;
        $cachedOtp = Cache::get($key);

        if (!$cachedOtp || $cachedOtp != $request->otp) {
            return response()->json(['message' => 'رمز التحقق غير صحيح أو منتهي الصلاحية.'], 400);
        }

        Cache::forget($key);

        return response()->json(['success' => true, 'message' => 'تم التحقق بنجاح']);
    }
}

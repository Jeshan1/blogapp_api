<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
        // Set the Stripe secret key
        Stripe::setApiKey('sk_test_51Qvj8RH7rHYG7fpooYmcjwAOXSFWOYNdUCpgzXWX1sAPIIfEP5xVsodbyHXFJj5QrVvA6cdrid4f16uutGyVY2GB00Kszbq6wy');

        // You can hard-code a default donation amount, or get it from the request
        $amount = $request->amount ?? 500; // Default: $5 donation

        // Create a payment intent based on the donation amount
        $paymentIntent = PaymentIntent::create([
            'amount' => $amount * 100, // Convert amount to cents
            'currency' => 'usd',
        ]);

        return response()->json([
            'clientSecret' => $paymentIntent->client_secret
        ]);
    }

    public function handlePaymentSuccess(Request $request)
    {
        // Store the payment details after successful payment
        $payment = Payment::create([
            'amount' => $request->amount,
            'stripe_payment_id' => $request->stripe_payment_id,
            'currency' => 'usd',
            'status' => 'successful',
            'donor_name' => $request->name, // Pass donor name if needed
        ]);

        return response()->json(['message' => 'Donation successful!']);
    }
}

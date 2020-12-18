<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function checkout()
    {
        // Enter Your Stripe Secret
        Stripe::setApiKey('use-your-stripe-key-here');

        $amount = 100;
        $amount *= 100;
        $amount = (int) $amount;

        $payment_intent = PaymentIntent::create([
            'description' => 'Stripe Test Payment',
            'amount' => $amount,
            'currency' => 'INR',
            'description' => 'Payment From Codehunger',
            'payment_method_types' => ['card'],
        ]);
        $intent = $payment_intent->client_secret;

        return view('checkout.credit-card', compact('intent'));
    }
}

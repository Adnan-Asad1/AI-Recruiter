<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StripeController extends Controller
{
    public function bill_form(){

        $user = Auth::user(); // get logged-in user
        $credits = $user->credit ?? 0;

        return view('billing.billing', compact('credits'));
    }
 
    public function charge(Request $request)
    {
        try {
            
            $user = Auth::user(); // Get the logged-in user

            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
            $charge = $stripe->charges->create([
                'amount' => $request->price * 100,  // 7$ = 7 cents *100 => 700c ents
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => 'This is the Customer Actual payment',
            ]);

            // Update user's credits with the purchased interviews
           if($charge && $charge->status === 'succeeded'){
                $purchasedInterviews = (int) $request->interviews; // convert string to int
                $user->credit = ($user->credit ?? 0) + $purchasedInterviews;
                $user->save();
            }

            return redirect()->back()->with('success', 'Payment successful!');

        }

        catch (\Exception $e) 
        {
            return response()->json([
                'error' => $e->getMessage() ?: "Payment failed"
            ]);
        }

    }

}

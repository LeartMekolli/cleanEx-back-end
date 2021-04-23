<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe;

class StripePaymentController extends Controller
{
    //
    public function stripe(){

    }

    public function stripe_post(Request $request){

        
        Stripe\Stripe::setApiKey('sk_test_51IdEftCEZBIMzOn9keFVwjQSlE5zxL1IlPb5ugAEf7N3auBQYf8QoPn4IRqNuZY18BaRAfYBCAVR7VIf2UncE11M00GAvkgpmn');
        
        return Stripe\Charge::create ([
                "amount" => 100 * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Test payment from itsolutionstuff.com." 
        ]);
    }
}

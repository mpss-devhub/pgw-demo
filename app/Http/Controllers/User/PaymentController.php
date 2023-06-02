<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    //
    use PaymentService;

    function directCheckout(){
        $cartProducts = Auth::user()->cart->groupBy('id');

        $cartTotalPrice = $cartProducts->sum(function ($group) {
            return $group->sum('price');
        });


       $paymentCategoriesWithPayments = $this->createPaymentAndGetPaymentList($cartTotalPrice,Auth::user()->cart->pluck('id')->all());

       if(!$paymentCategoriesWithPayments){
           return redirect()->back();
       }

       return view('checkout',compact('paymentCategoriesWithPayments'));
    }
}

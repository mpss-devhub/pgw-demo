<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\PaymentService;

class PaymentController extends Controller
{
    //
    use PaymentService;

    function directCheckout(){
       $paymentCategoriesWithPayments = $this->getAvailablePayments();

       return view('checkout',compact('paymentCategoriesWithPayments'));
    }
}

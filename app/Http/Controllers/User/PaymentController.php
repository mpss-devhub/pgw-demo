<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\PaymentService;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    //
    use PaymentService,ApiResponseHelpers;

    function directCheckout(){
        $cartProducts = Auth::user()->cart->groupBy('id');

        $cartTotalPrice = Auth::user()->cart->sum('price');


       $paymentCategoriesWithPayments = $this->createPaymentAndGetPaymentList($cartTotalPrice,Auth::user()->cart->pluck('id')->all());

       if(!$paymentCategoriesWithPayments){
           return redirect()->back();
       }
       $paymentId=Payment::latest()->first()->id;


       return view('checkout',compact('paymentCategoriesWithPayments','cartTotalPrice','cartProducts','paymentId'));
    }

    function doWebPay(Request $request){
        $response = $this->payWithSelectedPayment($request->paymentId,$request->paymentCode,$request->except(['_token','paymentId','paymentCode']));
        return redirect()->away($response["data"]["redirectUrl"]);
    }
    function doOtherPay(Request $request){
        $response = $this->payWithSelectedPayment($request->paymentId,$request->paymentCode,["phoneNo"=>$request->phoneNumber]);
        return $this->respondWithSuccess(["type"=>"QR","data"=>$response["data"]["qrImg"]]);
    }
}

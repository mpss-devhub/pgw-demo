<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\MPSSBackendCallback;
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
    function redirectCheckout(){

        $cartTotalPrice = Auth::user()->cart->sum('price');

        return redirect()->away($this->getRedirectUrl($cartTotalPrice, Auth::user()->cart->pluck('id')->all()));
    }

    function doWebPay(Request $request){
        $response = $this->payWithSelectedPayment($request->paymentId,$request->paymentCode,$request->except(['_token','paymentId','paymentCode']));
        return redirect()->away($response["data"]["redirectUrl"]);
    }
    function doOtherPay(Request $request){
        $response = $this->payWithSelectedPayment($request->paymentId,$request->paymentCode,["phoneNo"=>$request->phoneNo]);
        return $this->respondWithSuccess(["type"=>"QR","data"=> $response["data"]["qrImg"] ?? $response["data"]]);
    }

    function showPaymentStatus(Request $request)
    {
        $payment = null;

        if(!isset($request->respCode) || !isset($request->invoiceNo) || (isset($request->respCode) && $request->respCode!=="0000")){
            return view('payment-status',compact('payment'));
        }

        $payment = Payment::where('invoice_id',$request->invoiceNo)->get()->first();

        return view('payment-status',compact('payment'));
    }

    function poolPaymentStatus(Payment $payment){
             $payment = Payment::find($payment->id);


             if ($payment->status === "SUCCESS") {
                    return response()->json(['status' => 'success']);
             }

            return response()->json(['status' => 'waiting']);
    }

    function storeDirectCallbackStatus(MPSSBackendCallback $request)
    {
        return response()->json(["message"=>$this->storeDirectPaymentStatus($request)]);
    }
    function storeRedirectCallbackStatus(MPSSBackendCallback $request)
    {
        return response()->json(["message"=>$this->storeRedirectPaymentStatus($request)]);
    }
}

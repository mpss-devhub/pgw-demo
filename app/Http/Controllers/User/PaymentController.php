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

        if(Auth::user()->cart->count()<=0){
            return redirect()->route('home');
        }


       $paymentAndCategories = $this->createPaymentAndGetPaymentList($cartTotalPrice,Auth::user()->cart->pluck('id')->all());
       if(!$paymentAndCategories){
           return redirect()->back();
       }
       $paymentId= $paymentAndCategories->payment->id;
       $paymentCategoriesWithPayments = $paymentAndCategories->categories;

       return view(
           'checkout',
           compact(
               'paymentCategoriesWithPayments',
               'cartTotalPrice',
               'cartProducts',
               'paymentId'
           ));
    }
    function redirectCheckout(){

        $cartTotalPrice = Auth::user()->cart->sum('price');

        return redirect()->away($this->getRedirectUrl($cartTotalPrice, Auth::user()->cart->pluck('id')->all()));
    }

    function doWebPay(Request $request){
        $response = $this->payWithSelectedPayment($request->paymentId,$request->paymentCode,$request->except(['_token','paymentId','paymentCode']));
        if(isset($response["data"]["redirectUrl"])) {
            return redirect()->away($response["data"]["redirectUrl"]);
        }
        return redirect()->back();

    }
    function doOtherPay(Request $request){
        $response = $this->payWithSelectedPayment($request->paymentId,$request->paymentCode,["phoneNo"=>$request->phoneNo]);
        if($response["respCode"]==="0000" && isset($response["data"])){
            if(isset($response["data"]["qrImg"])){
                $type="QR";
                $data =  $response["data"]["qrImg"];
            }else if(isset($response["data"]["deeplink"])){
                $type="DEEP_LINK";
                $data =  $response["data"]["deeplink"];
            }else{
                $type="MESSAGE";
                $data = $response["data"];
            }
            return $this->respondWithSuccess(
                [
                    "status"=>$response["respCode"],
                    "data"=> [
                        "type"=>$type,
                        "data"=>$data
                    ]              ]
            );
        }
        return $this->respondWithSuccess([
            "status"=>$response["respCode"],
            "message"=> $response["respMsg"]
        ]);
    }

    function showPaymentStatus(Request $request)
    {

        $cartProducts = Auth::user()->cart->groupBy('id');


        $cartTotalPrice = Auth::user()->cart->sum('price');

        if(!isset($request->respCode) || !isset($request->invoiceNo)){
            return redirect()->route('home');
        }

        $payment = null;

        if($request->respCode==='0000') {
            $payment = Payment::where('invoice_id', $request->invoiceNo)->get()->first();
            $payment?->user->cart()->detach();
        }

        $paymentCategoriesWithPayments = null;


        return view(
            'payment-status',
            compact(
                'paymentCategoriesWithPayments',
                'cartTotalPrice',
                'cartProducts',
                'payment'
            ));
    }

    function checkPaymentStatus(Payment $payment){
             $payment = Payment::find($payment->id);

             if ($payment->status === "SUCCESS") {
                    return response()->json([
                        'status' => 'success',
                        'data'=>$payment
                    ]);
             }
            if ($payment->status === "FAIL") {
                return response()->json(['status' => 'failed']);
            }

            return response()->json(['status' => 'waiting']);
    }

    function storeDirectCallbackStatus(MPSSBackendCallback $request)
    {
        $this->storeDirectPaymentStatus($request);
        return response()->json(["message"=>"success"]);
    }
    function storeRedirectCallbackStatus(MPSSBackendCallback $request)
    {
        $this->storeRedirectPaymentStatus($request->all());
        return response()->json(["message"=>"success"]);
    }
}

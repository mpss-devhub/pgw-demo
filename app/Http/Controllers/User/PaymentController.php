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

    function poolPaymentStatus(Payment $payment){
            $timeout = 50; //
            $endTime = time() + $timeout;


            while (time() < $endTime) {
                $payment = Payment::find($payment->id);


                if ($payment->status === "SUCCESS") {
                    return response()->json(['status' => 'success']);
                }

                usleep(500000);
            }

            return response()->json(['status' => 'timeout']);
    }

    function storeGatewayPaymentStatusCallback(MPSSBackendCallback $request)
    {
        return response()->json(["message"=>$this->storePaymentStatus($request)]);
    }
}

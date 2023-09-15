<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\MPSSBackendCallback;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{

    use PaymentService, ApiResponseHelpers;

    function directCheckout()
    {
        $cartProducts = Auth::user()->cart->groupBy('id');

        $cartTotalPrice = Auth::user()->cart->sum('price');

        if (Auth::user()->cart->count() <= 0) {
            return redirect()->route('home');
        }

       $paymentAndCategories = $this->createPaymentAndGetPaymentList($cartTotalPrice,Auth::user()->cart->pluck('id')->all());
       if(!$paymentAndCategories){
           return redirect()->back();
       }
       $paymentId= $paymentAndCategories->payment->unique_id;
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
    function redirectCheckout()
    {

        $cartTotalPrice = Auth::user()->cart->sum('price');

        $redirectUrl = $this->getRedirectUrl($cartTotalPrice, Auth::user()->cart->pluck('id')->all());

        if (!$redirectUrl)
            return redirect()->back();

        return redirect()->away($redirectUrl);
    }

    function doWebPay(Request $request)
    {
        $response = $this->payWithSelectedPayment($request->paymentId, $request->paymentCode, $request->except(['_token', 'paymentId', 'paymentCode']));
        if (isset($response["data"]["redirectUrl"])) {
            return redirect()->away($response["data"]["redirectUrl"]);
        }
        return redirect()->back();

    }
    function doOtherPay(Request $request)
    {
        $response = $this->payWithSelectedPayment($request->paymentId, $request->paymentCode, ["phoneNo" => $request->phoneNo]);
        if ($response["respCode"] === "0000" && isset($response["data"])) {
            if (isset($response["data"]["qrImg"])) {
                $type = "QR";
                $data = $response["data"]["qrImg"];
            } else if (isset($response["data"]["deeplink"])) {
                $type = "DEEP_LINK";
                $data = $response["data"]["deeplink"];
            } else {
                $type = "MESSAGE";
                $data = $response["data"];
            }
            return $this->respondWithSuccess(
                [
                    "status" => $response["respCode"],
                    "data" => [
                        "type" => $type,
                        "data" => $data
                    ]
                ]
            );
        }
        return $this->respondWithSuccess([
            "status" => $response["respCode"],
            "message" => $response["respMsg"]
        ]);
    }

    /**
     * used in redirect payment
     * frontend calllback called from octoverse
     * eg. usages show payment fail , success status to user
     */
    function showPaymentStatus(Request $request)
    {

        $cartProducts = Auth::user()->cart->groupBy('id');


        $cartTotalPrice = Auth::user()->cart->sum('price');

        if (!isset($request->respCode) || !isset($request->invoiceNo)) {
            return redirect()->route('home');
        }

        $payment = null;

        if ($request->respCode === '0000') {
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
            )
        );
    }

     /**
     * used in direct payment
     * get pending payment status API
     * eg. usage app is waiting for payment confirmation to complete and want to show if payment is done or not
     */
    function checkPaymentStatus($paymentUniqueId){
             $payment = Payment::where('unique_id',$paymentUniqueId)->get()->first();

             if ($payment->status === "SUCCESS") {
                    return response()->json([
                        'status' => 'success',
                        'data'=>$payment
                    ]);
             }
            if ($payment->status === "FAIL") {
                return response()->json(['status' => 'failed']);
            }
    }



    /**
     * backend callback APIs
     */

    function storeDirectCallbackStatus(MPSSBackendCallback $request)
    {
        $this->storeDirectPaymentStatus($request);
        return response()->json(["message" => "success"]);
    }
    function storeRedirectCallbackStatus(MPSSBackendCallback $request)
    {
        $this->storeRedirectPaymentStatus($request->all());
        return response()->json(["message" => "success"]);
    }
}
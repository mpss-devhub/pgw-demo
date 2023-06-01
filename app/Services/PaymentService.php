<?php
namespace App\Services;

use App\Models\Payment;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Firebase\JWT\Key;

trait PaymentService{
    function getPaymentFromApi($payData){
        $baseUrl =  config('octoverse.base_url');
        $resourceUrl = 'auth/token';
        $url = $baseUrl.$resourceUrl;

        $response = Http::post($url, ["payData"=>$payData]);

        return $response;
    }

    function getTokens(array $paymentData){
        $payData = $this->getEncodedJWTPayload($paymentData);
        $paymentTokenData = $this->getPaymentFromApi($payData)->json()['data'];
        $paymentToken = $this->decodePaymentToken($paymentTokenData);
        return $paymentToken;
    }

    function getAvailablePayments($tokens,$payment):array{
        $baseUrl =  config('octoverse.base_url');
        $resourceUrl = 'getAvailablePaymentsList';
        $url = $baseUrl.$resourceUrl;

        $paymentAccessToken = $tokens->accessToken;

        $response = Http::withHeaders([
            'Authorization' => "Bearer $paymentAccessToken"
        ])->post($url,["paymentToken"=> $tokens->paymentToken]);


        return $response->json()['data']['paymentList'];
    }
    function getEncodedJWTPayload($paymentData):string{

        $payload = [
            'merchantID' => config('octoverse.merchant_id'),
            'frontendUrl' => 'https://someurl.com/api',
            'backendUrl' => 'https://someurl.com/api',
            'userDefination1'=>'one',
            'userDefination2'=>'two',
            'userDefination3'=>'three'
        ];
        $payload=array_merge($payload,$paymentData);


        return JWT::encode($payload, config('octoverse.merchant_secret_key'),'HS256');
    }

    public function decodePaymentToken($encodedJWT){
      return   JWT::decode($encodedJWT, new Key(config('octoverse.merchant_secret_key'), 'HS256'));
    }

    public function getUniqueInvoiceId(){
        return config('octoverse.invoice_prefix').uniqid();
    }

    public function createPaymentAndGetPaymentList($totalAmount,array $productIds){

        $payment = $this->createPayment($totalAmount,$productIds);
        $tokens = $this->getTokens([
            "invoiceNo"=>$payment->invoice_id,
            "amount"=>$payment->amount,
            "currencyCode"=>$payment->currency_code
        ]);

        return $this->getAvailablePayments($tokens,$payment);
    }

    public function createPayment($totalAmount,array $productIds){
        $payment=Payment::create([
            "amount"=>$totalAmount,
            "invoice_id"=>$this->getUniqueInvoiceId(),
            "currency_code"=>"MMK"
        ]);
        $payment->products()->attach($productIds);

        return $payment;
    }
}

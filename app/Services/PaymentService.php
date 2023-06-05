<?php
namespace App\Services;

use App\Models\Payment;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Crypt;
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
        $payload = [
            'merchantID' => config('octoverse.merchant_id'),
            'frontendUrl' => config('octoverse.frontend_callback'),
            'backendUrl' => route('octoverse.backend.callback'),
            'userDefination1'=>'one',
            'userDefination2'=>'two',
            'userDefination3'=>'three'
        ];
        $payload=array_merge($payload,$paymentData);


        $payData = $this->getEncodedJWTPayload($payload);
        $paymentTokenData = $this->getPaymentFromApi($payData)->json()['data'];
        $paymentToken = $this->decodePaymentToken($paymentTokenData);
        return $paymentToken;
    }

    function getRedirectUrl($totalAmount,$productIds)
    {
        $payment = $this->createPayment($totalAmount,$productIds);

        $payload = [
            'merchantID' => config('octoverse.merchant_id'),
            'frontendUrl' => config('octoverse.frontend_callback'),
            'backendUrl' => route('octoverse.backend.callback'),
            'userDefination1'=>'one',
            'userDefination2'=>'two',
            'userDefination3'=>'three'
        ];
        $payload=array_merge($payload,[
            "invoiceNo"=>$payment->invoice_id,
            "amount"=>$totalAmount,
            "currencyCode"=>"MMK"
        ]);


        $payData = $this->getEncodedJWTPayload($payload);
        $paymentTokenData = $this->getPaymentFromApi($payData)->json()['data'];
        $paymentToken = $this->decodePaymentToken($paymentTokenData);
        return $paymentToken->paymenturl;
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
    function getEncodedJWTPayload($payload):string{



        return JWT::encode($payload, config('octoverse.merchant_secret_key'),'HS256');
    }

    public function decodePaymentToken($encodedJWT){
      return   JWT::decode($encodedJWT, new Key(config('octoverse.merchant_secret_key'), 'HS256'));
    }

    public function getUniqueInvoiceId(){
        return config('octoverse.invoice_prefix').uniqid();
    }

    public function createPaymentAndGetPaymentList($totalAmount,array $productIds){

        try {
            $payment = $this->createPayment($totalAmount,$productIds);
            $tokens = $this->getTokens([
                "invoiceNo"=>$payment->invoice_id,
                "amount"=>$payment->amount,
                "currencyCode"=>$payment->currency_code
            ]);
            $payment->payment_token = $tokens->paymentToken;
            $payment->access_token = $tokens->accessToken;
            $payment->save();

            return $this->getAvailablePayments($tokens,$payment);
        }catch (\Exception $e){
            return false;
        }
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

    public function payWithSelectedPayment($paymentId,$paymentCode,array $attributes){
        $baseUrl =  config('octoverse.base_url');
        $resourceUrl = 'dopay';
        $url = $baseUrl.$resourceUrl;

        $payment = Payment::find($paymentId);


        $jwtPayload = $this->encryptAES(json_encode($attributes),config('octoverse.merchant_data_key'));


        $response = Http::withHeaders([
            'Authorization' => "Bearer $payment->access_token"
        ])->post($url,[
            "paymentToken"=> $payment->payment_token,
            "paymentCode"=>$paymentCode,
            "payData"=>$jwtPayload
        ]);
        return $response->json();
   }


    function encryptAES($plainText, $key)
    {
        $cipher = "AES-128-ECB";
        $options = OPENSSL_RAW_DATA;
        $encryptedText = openssl_encrypt($plainText, $cipher, $key, $options);

        return rtrim(base64_encode($encryptedText));
    }
    function decryptAES($encryptedText, $key)
    {
        $cipher = "AES-128-ECB";
        $options = OPENSSL_RAW_DATA;
        $decodedText = base64_decode($encryptedText);
        return openssl_decrypt($decodedText, $cipher, $key, $options);
    }


    function storePaymentStatus($response){
        $responseData = $this->decryptAES($response->data,config('octoverse.merchant_data_key'));
//        $invoiceNumber = $responseData["invoiceNo"];
//        Payment::where('invoice_id',$invoiceNumber)->update(['status'=>$responseData['SUCCESS']]);
        return $responseData;
    }

}

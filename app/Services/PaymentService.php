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

        return Http::post($url, ["payData"=>$payData]);
    }

    function getTokens(array $paymentData){
        $payload = [
            'merchantID' => config('octoverse.direct_merchant_id'),
            'frontendUrl' => "https://frontend.call",
            'backendUrl' => route('octoverse.backend.direct-callback'),
            'userDefination1'=>'one',
            'userDefination2'=>'two',
            'userDefination3'=>'three'
        ];
        $payload=array_merge($payload,$paymentData);


        $payData = $this->getEncodedJWTPayload($payload,config('octoverse.direct_merchant_secret_key'));
        $paymentTokenData = $this->getPaymentFromApi($payData)->json()['data'];
        $paymentToken = $this->decodePaymentToken($paymentTokenData,config('octoverse.direct_merchant_secret_key'));
        return $paymentToken;
    }

    function getRedirectUrl($totalAmount,$productIds)
    {
        $payment = $this->createPayment($totalAmount,$productIds);

        $payload = [
            'merchantID' => config('octoverse.redirect_merchant_id'),
            'frontendUrl' =>route('payment.showstatus'),
            'backendUrl' => route('octoverse.backend.redirect-callback'),
            'userDefination1'=>'one',
            'userDefination2'=>'two',
            'userDefination3'=>'three'
        ];
        $payload=array_merge($payload,[
            "invoiceNo"=>$payment->invoice_id,
            "amount"=>$totalAmount,
            "currencyCode"=>"MMK"
        ]);

        $payData = $this->getEncodedJWTPayload($payload,config('octoverse.redirect_merchant_secret_key'));
        $paymentTokenData = $this->getPaymentFromApi($payData)->json()['data'];
        $paymentToken = $this->decodePaymentToken($paymentTokenData,config('octoverse.redirect_merchant_secret_key'));
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
    function getEncodedJWTPayload($payload,$secret):string{
        return JWT::encode($payload, $secret,'HS256');
    }

    public function decodePaymentToken($encodedJWT,$secret){
      return   JWT::decode($encodedJWT, new Key($secret, 'HS256'));
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


        $jwtPayload = $this->encryptAES(
            json_encode($attributes),
            config('octoverse.direct_merchant_data_key')
        );


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


    function storeDirectPaymentStatus($responseData){
        $callbackPaymentData = json_decode($this->decryptAES($responseData["data"],config('octoverse.direct_merchant_data_key')));
        $payment = Payment::where('invoice_id',$callbackPaymentData->invoiceNo)->get()->first();

        if(!$payment) return null;

        $payment->update([
            "status"=>$callbackPaymentData->status
        ]);
        return $payment;
    }
    function storeRedirectPaymentStatus($responseData){
        $callbackPaymentData = json_decode($this->decryptAES($responseData["data"],config('octoverse.redirect_merchant_data_key')));
        $payment = Payment::where('invoice_id',$callbackPaymentData->invoiceNo)->get()->first();

        if(!$payment) return null;

        $payment->update([
            "status"=>$callbackPaymentData->status
        ]);
        return $payment;
    }
}

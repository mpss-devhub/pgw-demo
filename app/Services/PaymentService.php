<?php
namespace App\Services;

use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Firebase\JWT\Key;

trait PaymentService{
    function getPaymentFromApi(){
        $baseUrl =  config('octoverse.base_url');
        $resourceUrl = 'auth/token';
        $url = $baseUrl.$resourceUrl;

        $response = Http::post($url, ["payData"=>$this->getEncodedJWTPayload()]);

        return $response;
    }

    function getTokens(){
        $paymentTokenData = $this->getPaymentFromApi()->json()['data'];
        $paymentToken = $this->decodePaymentToken($paymentTokenData);
        return $paymentToken;
    }

    function getAvailablePayments():array{
        $baseUrl =  config('octoverse.base_url');
        $resourceUrl = 'getAvailablePaymentsList';
        $url = $baseUrl.$resourceUrl;
        $tokens = $this->getTokens();

        $paymentAccessToken = $tokens->accessToken;

        $response = Http::withHeaders([
            'Authorization' => "Bearer $paymentAccessToken"
        ])->post($url,["paymentToken"=> $tokens->paymentToken]);


        return $response->json()['data']['paymentList'];
    }
    function getEncodedJWTPayload():string{

        $payload = [
            'merchantID' => config('octoverse.merchant_id'),
            'invoiceNo' => 'INV023423424234266',
            'amount' => '8000',
            'currencyCode' => 'MMK',
            'frontendUrl' => 'https://someurl.com/api',
            'backendUrl' => 'https://someurl.com/api',
            'userDefination1'=>'one',
            'userDefination2'=>'two',
            'userDefination3'=>'three'
        ];


        return JWT::encode($payload, config('octoverse.merchant_secret_key'),'HS256');
    }

    public function decodePaymentToken($encodedJWT){
      return   JWT::decode($encodedJWT, new Key(config('octoverse.merchant_secret_key'), 'HS256'));
    }
}

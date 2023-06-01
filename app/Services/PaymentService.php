<?php
namespace App\Services;

use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

trait PaymentService{
    function getPaymentToken(){
        $baseUrl =  config('octoverse.base_url');
        $resourceUrl = 'auth/token';
        $url = $baseUrl.$resourceUrl;
        $client = new Client();

        $response = Http::post($url, ["payData"=>$this->getEncodedJWTPayload()]);

        return $response;
    }
    function getEncodedJWTPayload():string{

        $payload = [
            'merchantID' => config('octoverse.merchant_id'),
            'invoiceNo' => 'INV023423424234244',
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
}

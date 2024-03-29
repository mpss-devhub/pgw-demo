<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Payment;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Str;

trait PaymentService
{
    function getPaymentFromApi($payData)
    {
        $baseUrl = config('octoverse.base_url');
        $resourceUrl = 'auth/token';
        $url = $baseUrl . $resourceUrl;

        return Http::post($url, ["payData" => $payData]);
    }

    /**
     * get access token , payment token from octoverse
     */
    function getTokens(array $paymentData)
    {
        $payload = [
            'merchantID' => config('octoverse.direct_merchant_id'),
            'frontendUrl' => route('payment.showstatus'),
            'backendUrl' => route('octoverse.backend.direct-callback'),
            'userDefination1' => 'one',
            'userDefination2' => 'two',
            'userDefination3' => 'three'
        ];
        $payload = array_merge($payload, $paymentData);


        $payData = $this->getEncodedJWTPayload($payload, config('octoverse.direct_merchant_secret_key'));

        $paymentTokenData = $this->getPaymentFromApi($payData)->json()['data'];

        if ($paymentTokenData === null)
            return null;

        $paymentToken = $this->decodePaymentToken($paymentTokenData, config('octoverse.direct_merchant_secret_key'));

        return $paymentToken;
    }

    function getRedirectUrl($totalAmount, $productIds)
    {
        $payment = $this->createPayment($totalAmount, $productIds);

        $payload = [
            'merchantID' => config('octoverse.redirect_merchant_id'),
            'frontendUrl' => route('payment.showstatus'),
            'backendUrl' => route('octoverse.backend.redirect-callback'),
            'userDefination1' => 'one',
            'userDefination2' => 'two',
            'userDefination3' => 'three'
        ];
        $payload = array_merge($payload, [
            "invoiceNo" => $payment->invoice_id,
            "amount" => $totalAmount,
            "currencyCode" => "MMK"
        ]);

        $payData = $this->getEncodedJWTPayload($payload, config('octoverse.redirect_merchant_secret_key'));

        $paymentTokenData = $this->getPaymentFromApi($payData)->json()['data'];

        if ($paymentTokenData === null)
            return null;

        $paymentToken = $this->decodePaymentToken($paymentTokenData, config('octoverse.redirect_merchant_secret_key'));
        return $paymentToken->paymenturl;
    }

    function getAvailablePayments($tokens, $payment): array
    {
        $baseUrl = config('octoverse.base_url');
        $resourceUrl = 'getAvailablePaymentsList';
        $url = $baseUrl . $resourceUrl;

        $paymentAccessToken = $tokens->accessToken;

        $response = Http::withHeaders([
            'Authorization' => "Bearer $paymentAccessToken"
        ])->post($url, ["paymentToken" => $tokens->paymentToken]);


        return $response->json()['data']['paymentList'];
    }
    function getEncodedJWTPayload($payload, $secret): string
    {
        return JWT::encode($payload, $secret, 'HS256');
    }

    public function decodePaymentToken($encodedJWT, $secret)
    {
        return JWT::decode($encodedJWT, new Key($secret, 'HS256'));
    }

    public function getUniqueInvoiceId()
    {
        return config('octoverse.invoice_prefix') . uniqid();
    }

    /**
     * get available payments list from octoverse and return them in grouped categories
     * eg. usages , show a list of available payments to end-user
     */
    public function createPaymentAndGetPaymentList($totalAmount, array $productIds)
    {

        try {
            $payment = $this->createPayment($totalAmount, $productIds);

            $tokens = $this->getTokens([
                "invoiceNo" => $payment->invoice_id,
                "amount" => $payment->amount,
                "currencyCode" => $payment->currency_code
            ]);

            if (!$tokens) {
                return false;
            }

            $payment->payment_token = $tokens->paymentToken;
            $payment->access_token = $tokens->accessToken;
            $payment->save();

            $paymentAndAvailableCategories = new \stdClass();
            $paymentAndAvailableCategories->payment = $payment;
            $paymentAndAvailableCategories->categories = $this->getAvailablePayments($tokens, $payment);

            if (!$paymentAndAvailableCategories->categories) {
                return false;
            }
            return $paymentAndAvailableCategories;
        } catch (\Exception $e) {
            return false;
        }
    }

   /**
     * create new payment object for storing payment status and details
     * this will also be used when successful backend callback were called from octoverse
     * eg. usages store payment information, payment status,tokens products related with the payment , callback responses from octoverse etc
     */
    public function createPayment($totalAmount,array $productIds){
        $payment=Payment::create([
            "amount"=>$totalAmount,
            "unique_id"=>Str::uuid(),
            "invoice_id"=>$this->getUniqueInvoiceId(),
            "currency_code"=>"MMK",
            "user_id"=>auth()->user()->id
        ]);
  
        $payment->products()->attach($productIds);

        return $payment;
    }

    /**
     * makes do pay request to octoverse with chosen payment method
     */
    public function payWithSelectedPayment($paymentId, $paymentCode, array $attributes)
    {
        $baseUrl = config('octoverse.base_url');
        $resourceUrl = 'dopay';
        $url = $baseUrl . $resourceUrl;

        $payment = Payment::where("unique_id",$paymentId)->get()->first();


        $jwtPayload = $this->encryptAES(
            json_encode($attributes),
            config('octoverse.direct_merchant_data_key')
        );


        $response = Http::withHeaders([
            'Authorization' => "Bearer $payment->access_token"
        ])->post($url, [
                    "paymentToken" => $payment->payment_token,
                    "paymentCode" => $paymentCode,
                    "payData" => $jwtPayload
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


    /**
     * store payment status when direct backend callback is returned from octoverse
     * clear cart and update payment status if successful
     */
    function storeDirectPaymentStatus($responseData)
    {
        $callbackPaymentData = json_decode($this->decryptAES($responseData["data"], config('octoverse.direct_merchant_data_key')));
        $payment = Payment::where('invoice_id', $callbackPaymentData->invoiceNo)->get()->first();

        if (!$payment)
            return null;

        $payment->update([
            "status" => $callbackPaymentData->status
        ]);

        if ($payment->status === "SUCCESS") {
            $payment->user->cart()->detach();
        }
        return $payment;
    }

    /**
     * store payment status when redirect backend callback is returned from octoverse
     * clear cart and update payment status if successful
     */
    function storeRedirectPaymentStatus($responseData)
    {
        $callbackPaymentData = json_decode($this->decryptAES($responseData["data"], config('octoverse.redirect_merchant_data_key')));
        $payment = Payment::where('invoice_id', $callbackPaymentData->invoiceNo)->get()->first();

        if (!$payment)
            return null;

        $payment->update([
            "status" => $callbackPaymentData->status
        ]);

        if ($payment->status === "SUCCESS") {
            $payment->user->cart()->detach();
        }

        return $payment;
    }
}
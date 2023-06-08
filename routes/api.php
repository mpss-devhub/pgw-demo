<?php

use App\Http\Controllers\User\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function() {
    Route::post('/non-web-pay', [PaymentController::class,'doOtherPay'])->name('non-web-pay.getqr');
    Route::get('/payments/{payment}/status', [PaymentController::class,'checkPaymentStatus'])->name('non-web-pay.status');
    Route::post('/callbacks/direct-payment-status', [PaymentController::class,'storeDirectCallbackStatus'])->name('octoverse.backend.direct-callback');
    Route::post('/callbacks/redirect-payment-status', [PaymentController::class,'storeRedirectCallbackStatus'])->name('octoverse.backend.redirect-callback');
});


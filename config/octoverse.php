<?php

use Laravel\Telescope\Http\Middleware\Authorize;
use Laravel\Telescope\Watchers;

return [

    'base_url' => env('OCTOVERSE_BASE_URL'),

    'merchant_id' => env('OCTOVERSE_MERCHANT_ID'),

    'merchant_secret_key' => env('OCTOVERSE_MERCHANT_SECRET_KEY'),

    'merchant_data_key' => env('OCTOVERSE_MERCHANT_DATA_KEY'),

    'invoice_prefix'=>env('OCTOVERSE_INVOICE_PREFIX'),

    'frontend_callback'=>env('OCTOVERSE_FRONT_END_CALLBACK_URL'),

    'backend_callback'=>env('OCTOVERSE_BACK_END_CALLBACK_URL')
];

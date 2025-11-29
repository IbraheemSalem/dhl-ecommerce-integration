<?php

return [
    'api_base' => env('DHL_ECOMMERCE_BASE_URL', 'https://api.dhl.com/ecommerce'),
    'client_id' => env('DHL_ECOMMERCE_CLIENT_ID'),
    'client_secret' => env('DHL_ECOMMERCE_CLIENT_SECRET'),
    'account_number' => env('DHL_ECOMMERCE_ACCOUNT'),
    'webhook_secret' => env('DHL_WEBHOOK_SECRET'),
    'timeout' => 30,
];

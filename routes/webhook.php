<?php

use Illuminate\Support\Facades\Route;
use Ibraheem\DhlEcommerceIntegration\Http\Controllers\WebhookController;

Route::post('/dhl/webhook', [WebhookController::class, 'handle'])->name('dhl.webhook');

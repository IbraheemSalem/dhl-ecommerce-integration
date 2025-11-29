<?php

use Illuminate\Support\Facades\Route;
use Ibraheem\DhlEcommerceIntegration\Http\Controllers\AdminController;

Route::middleware(['web'])
    ->prefix('dhl-admin')
    ->name('dhl.admin.')
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::post('/settings', [AdminController::class, 'saveSettings'])->name('settings.save');
        Route::get('/merchants', [AdminController::class, 'merchants'])->name('merchants');
        Route::post('/merchants/add', [AdminController::class, 'addMerchant'])->name('merchants.add');
        Route::get('/logs', [AdminController::class, 'logs'])->name('logs');
    });

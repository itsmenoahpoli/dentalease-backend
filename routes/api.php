<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;


Route::prefix('v1')->group(function() {
    Route::prefix('auth')->group(function() {
        Route::post('login', [AuthController::class, 'login'])->name('auth.login');
        Route::post('request-code', [AuthController::class, 'requestCode'])->name('auth.request-code');

        Route::middleware('auth:sanctum')->group(function() {
            Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
        });
    });
});

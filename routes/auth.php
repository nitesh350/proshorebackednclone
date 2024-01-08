<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\EmailVerificationController;
use App\Http\Controllers\Api\Auth\ResentEmailVerificationController;

Route::get('/verify-email/{id}/{hash}', EmailVerificationController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

Route::post('/email/verification/resend', ResentEmailVerificationController::class)
                ->middleware(['auth:sanctum', 'throttle:6,1'])
                ->name('verification.send');

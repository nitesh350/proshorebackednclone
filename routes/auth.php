<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\Auth\EmailVerificationController;

Route::get('/verify-email/{id}/{hash}', EmailVerificationController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

Route::post('/reset-password', ResetPasswordController::class)
                ->middleware('guest')
                ->name('password.store');
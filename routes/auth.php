<?php


use App\Http\Controllers\Api\Auth\EmailVerificationController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\ResentEmailVerificationController;
use Illuminate\Support\Facades\Route;


Route::get('/verify-email/{id}/{hash}', EmailVerificationController::class)
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/logout', LogoutController::class)
    ->middleware('auth:sanctum')
    ->name('logout');

Route::post('/email/verification/resend', ResentEmailVerificationController::class)
    ->middleware(['auth:sanctum', 'throttle:6,1'])
    ->name('verification.send');

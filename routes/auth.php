<?php
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;


Route::post('/forgot-password', ForgotPasswordController::class)
                ->middleware('guest')
                ->name('password.email');
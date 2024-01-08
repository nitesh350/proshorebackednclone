<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginUserController;
use App\Http\Controllers\Api\Auth\RegisterUserController;


Route::post('/register', RegisterUserController::class)
    ->middleware('guest')
    ->name('register');

Route::post('/login', LoginUserController::class)
    ->middleware('guest')
    ->name('login');

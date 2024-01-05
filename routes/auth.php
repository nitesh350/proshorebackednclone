<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterUserController;

Route::post('/register',RegisterUserController::class)
                ->middleware('guest')
                ->name('register');


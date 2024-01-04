<?php

use App\Http\Controllers\Api\Auth\EmailVerificationController;

Route::get('/verify-email/{id}/{hash}', EmailVerificationController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');



<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;


class CustomPasswordServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Password::defaults(function (){
          $rule  = Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols();
                    return $rule;

        });
    }
}

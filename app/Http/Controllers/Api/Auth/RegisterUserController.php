<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\Auth\RegisterUserRequest;

class RegisterUserController extends Controller
{
    /**
  * @param RegisterUserRequest $request
  * @return void
  */  
    public function __invoke(RegisterUserRequest $request)
    {
        $data = $request->validated();
       
        $user = User::create($data);
        
        event(new Registered($user));

        return response()->noContent();
    }
}

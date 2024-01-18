<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserDataController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\UserDataResource
     */
    public function __invoke(Request $request): UserResource
    {
        $data =  auth()->user()->load('profile');
        return new UserResource($data);
    }
}

<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetRegisteredStudentController extends Controller
{
    /**
     * @return UserResource
     */
    public function __invoke(Request $request) : AnonymousResourceCollection
    {
        $students = User::where('user_type', 'student')->paginate(10);
        return UserResource::collection($students);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileStoreRequest;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function store(ProfileStoreRequest $request)
    {
        $data = $request->validated();
        $profile = Profile::create($data);
        return new ProfileResource($profile);
    }
}

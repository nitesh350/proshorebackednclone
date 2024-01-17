<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileStoreRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileController extends Controller
{
    /**
     * @param ProfileStoreRequest $request
     * @return JsonResource
     */
    public function store(ProfileStoreRequest $request): JsonResource
    {
        $data = $request->validated();
        $profile = Profile::create($data);
        return new ProfileResource($profile);
    }

    /**
     * @param Profile $profile
     * @param ProfileUpdateRequest $request
     * @return JsonResource
     */
    public function update(Profile $profile, ProfileUpdateRequest $request): JsonResource
    {
        $data = $request->validated();
        $profile->update($data);
        return new ProfileResource($profile);
    }
}

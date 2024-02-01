<?php

namespace App\Http\Repositories;

use App\Models\Profile;
use Illuminate\Support\Facades\Storage;

class ProfileRepository
{
    /**
     * @param array $data
     * @return Profile
     */
    public function store($data): Profile
    {
        $name = date('ymd') . time() . '.' . $data['avatar']->extension();
        $data['avatar'] = $data['avatar']->storeAs('images/profiles', $name);
        $profile = Profile::create($data);
        return $profile;
    }   
    
    /**
     * @param Profile $profile
     * @param array $data
     * @return Profile
     */
    public function update(Profile $profile, $data)
    {
        if (isset($data['avatar'])) {
            Storage::delete('public/images/profiles/' . $profile->avatar);
            $name = date('ymd') . time() . '.' . $data['avatar']->extension();
            $data['avatar'] = $data['avatar']->storeAs('images/profiles', $name);
        }
        $profile->update($data);

        return $profile;
    }
}

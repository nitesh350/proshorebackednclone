<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "skills" => $this->skills,
            "education" => $this->education,
            "experience" => $this->experience,
            "career" => $this->career,
            "avatar_url" => $this->avatar_url,
        ];
    }
}

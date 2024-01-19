<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'thumbnail' => $this->thumbnail_url,
            'description' => $this->description,
<<<<<<< HEAD
            'time' => $this->time . " Minutes",
            'retry_after' => $this->retry_after . " Days",
=======
            'time' => $this->time,
            'retry_after' => $this->retry_after,
>>>>>>> feature/get-quiz
            'status' => $this->status == 1 ? "Active" : "Inactive"
        ];
    }
}

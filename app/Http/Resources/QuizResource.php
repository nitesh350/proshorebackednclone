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
            'title' => $this->title,
            'slug' => $this->slug,
            'thumbnail' => asset('storage/images/quizzes') . "/" . $this->thumbnail,
            'description' => $this->description,
            'time' => $this->time . " " . "Minutes",
            'retry_after' => $this->retry_after . " " . "Days",
            'status' => $this->status == 1 ? "Active" : "Inactive"
        ];
    }
}

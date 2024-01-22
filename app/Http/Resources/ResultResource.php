<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResultResource extends JsonResource
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
            'user_id' => $this->user_id,
            'quiz_id' => $this->quiz_id,
            'passed' => $this->passed,
            'total_question' => $this->total_question,
            'total_answered' => $this->total_answered,
            'total_right_answer' => $this->total_right_answer,
            'total_time' => $this->total_time
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'title'          => $this->title,
            'description'    => $this->description,
            'rating'         => (float) $this->rating,
            'thumbnail'      => $this->thumbnail,
            'level'          => $this->level,
            'duration'       => (int) $this->duration,
            'enrolled_count' => (int) $this->enrolled_count,
            'status'         => $this->status,
            // Relasi hanya muncul jika sudah di-load (with)
            'category'       => new CourseCategoryResource($this->whenLoaded('category')),
            'instructor'     => new UserResource($this->whenLoaded('instructor')),
        ];
    }
}
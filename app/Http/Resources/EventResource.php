<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
        'id' => $this->id,
        'title' => $this->title,
        'image' => $this->image 
            ? asset('storage/' . $this->image)
            : null,
        'category' => new CategoryResource($this->whenLoaded('category')),
        'date' => $this->date,
        'time' => $this->time,
        'location' => $this->location,
        'description' => $this->description,
        'status' => $this->status,
    ];
    }
}

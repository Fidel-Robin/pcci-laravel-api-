<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage; // For S3 URL generation

class EventResource extends JsonResource
{
     /**
     * Helper to generate temporary URLs for S3/Backblaze
     * Copied from ApplicantResource for consistency
     */
    private function getS3Url($path, $minutes = 30)
    {
        if (!$path) return null;
        return Storage::disk('s3')->temporaryUrl($path, now()->addMinutes($minutes));
    }

    public function toArray($request): array
    {
        return [
        'id' => $this->id,
        'title' => $this->title,
        // 'image' => $this->image 
        //     ? asset('storage/' . $this->image)
        //     : null,

        'imagel' => $this->getS3Url($this->image, 120),    
        'category' => new CategoryResource($this->whenLoaded('category')),
        'date' => $this->date,
        'time' => $this->time,
        'location' => $this->location,
        'description' => $this->description,
        'status' => $this->status,
    ];
    }
}

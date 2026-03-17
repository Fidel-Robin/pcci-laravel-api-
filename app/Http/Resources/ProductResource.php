<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
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

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'description' => $this->description,
            
            // === PHOTO (Backblaze Temporary URL) ===
            // For products, you might want a longer duration (e.g., 2 hours / 120 mins) 
            // so the customer doesn't see broken images while browsing
            'photo_url' => $this->getS3Url($this->photo_path, 120),
                
            'status' => $this->status,
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
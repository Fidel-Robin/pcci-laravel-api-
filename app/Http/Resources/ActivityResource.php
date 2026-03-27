<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ActivityResource extends JsonResource
{
      /**
     * Helper to generate temporary URLs for S3/Backblaze
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
            'description' => $this->description,
            // 'image_url' => $this->image_path
            //     ? Storage::disk('public')->url($this->image_path)
            //     : null,

            'image_url'    => $this->getS3Url($this->image_path),

            'created_at' => $this->created_at,
        ];
    }
}
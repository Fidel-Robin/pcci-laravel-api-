<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\BoardPositionResource;

class BoardOfTrusteeResource extends JsonResource
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

                // 'image_url' => $this->image 
                //     ? url('storage/'.$this->image)
                //     : null,

            'image_url' => $this->getS3Url($this->image, 120), 

            'lastname' => $this->lastname,
            'firstname' => $this->firstname,
            'middlename' => $this->middlename,

            'gender' => $this->gender,

            'status' => $this->status,

            'position' => new BoardPositionResource($this->whenLoaded('position')),

            'created_at' => $this->created_at,
        ];
    }
}
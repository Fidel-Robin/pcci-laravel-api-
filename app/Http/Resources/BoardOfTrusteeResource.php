<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BoardOfTrusteeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'image_url' => $this->image 
                ? url('storage/'.$this->image)
                : null,

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
<?php

// app/Http/Resources/ProductResource.php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'description' => $this->description,
            'photo_url' => $this->photo_path 
                ? Storage::url($this->photo_path)
                : null,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ];
    }
}

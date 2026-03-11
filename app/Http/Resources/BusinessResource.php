<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessResource extends JsonResource
{
    /**
     * Transform the resource into an array for the public landing page.
     */
    public function toArray(Request $request): array
    {
        // We access the 'applicant' relationship since that holds the business details
        $applicant = $this->applicant;

        return [
            'slug' => $applicant?->slug, // Useful for the "View Details" URL
            'business_name' => $applicant?->registered_business_name,
            
            // This ensures the URL starts with http://127.0.0.1:8000/storage/
            'photo_url' => $applicant?->photo_path 
                ? asset('storage/' . $applicant->photo_path) 
                : asset('images/default-logo.png'),

            'tagline' => $applicant?->tagline ?? 'NA For your metal fabrication needs.',
            'description' => $applicant?->company_description ?? 'NA We provide high-quality metal fabrication services for various industries.',
            'phone_number' => $applicant?->phone_number,
            'location' => $applicant?->location, // e.g., "Sta. maria, Valenzuela City"
            
            // Assuming tags are stored as an array or a relationship
            'tags' => $applicant?->tags ?? [], 
            
            'business_hours' => $applicant?->business_hours,
            
            // We can still include status if the frontend needs to show 'Open' or 'Verified'
            'status' => $this->status, 
        ];
    }
}
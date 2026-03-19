<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessResource extends JsonResource
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


    /**
     * Transform the resource into an array for the public landing page.
     */
    public function toArray(Request $request): array
    {
        // We access the 'applicant' relationship since that holds the business details
        $applicant = $this->applicant;

        return [
            // 'slug' => $applicant?->slug, // Useful for the "View Details" URL

            // This ensures the URL starts with http://127.0.0.1:8000/storage/
            // 'photo_url' => $applicant?->photo_path 
            //     ? asset('storage/' . $applicant->photo_path);
            //     // : asset('images/default-logo.png'),

            'photo_url' => $this->getS3Url($this->photo_path, 120),


            'industry' => $applicant?->industry,
            'registered_business_name' => $applicant?->registered_business_name,
            'business_tagline' => $applicant?->business_tagline ?? 'this text shows coz this data is empty',
            'tags' => $applicant?->tags ?? [], 
            'telephone_no' => $applicant?->telephone_no ?? 'this text shows coz this data is empty',
            'location' => $applicant?->location, // e.g., "Sta. maria, Valenzuela City"
            
            'description' => $applicant?->about_description ?? 'this text shows coz this data is empty',
            'business_hours' => $applicant?->business_hours,
            
            // We can still include status if the frontend needs to show 'Open' or 'Verified'
            'status' => $this->status,
            
            'email' => $applicant?->email,
            'business_location' => [
                    'business_address'  => $applicant?->business_address,
                    'city_municipality' => $applicant?->city_municipality,
                    'province'          => $applicant?->province,
                    'region'            => $applicant?->region,
                    'zip_code'          => $applicant?->zip_code,
                    //link to google map, we can generate it using the address fields, but for now we will just add a placeholder
                    'location_link' => $applicant?->location_link ?? 'No.04 fatima lane La Milagrosa Village, Marikina Heights 1810',
                ],
        ];
    }
}
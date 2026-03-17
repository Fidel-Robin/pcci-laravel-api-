<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ApplicantResource extends JsonResource
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
        $user = $request->user();

        // PUBLIC (NO AUTH)
        if (!$user) {
            return [
                'id' => $this->id,
                'status' => $this->status,
                'date_submitted' => $this->date_submitted?->toDateString(),
            ];
        }

        // SUPER ADMIN / ADMIN
        if ($user->hasAnyRole(['super_admin', 'admin'])) {
            return [
                'id' => $this->id,
                'date_submitted'  => $this->date_submitted?->toDateString(),
                'status'          => $this->status,
                'date_approved'   => $this->date_approved?->toDateString(),
                'membership_type' => $this->membership_type,

                // === PHOTO & DOCUMENTS (Backblaze Temporary URLs) ===
                'photo_url'            => $this->getS3Url($this->photo_path, 60), // 1 hour for photos
                'mayors_permit_url'    => $this->getS3Url($this->mayors_permit_path),
                'dti_sec_url'          => $this->getS3Url($this->dti_sec_path),
                'proof_of_payment_url' => $this->getS3Url($this->proof_of_payment_path),

                'basic_profile' => [
                    'registered_business_name' => $this->registered_business_name,
                    'trade_name'               => $this->trade_name,
                    'business_location' => [
                        'business_address'  => $this->business_address,
                        'city_municipality' => $this->city_municipality,
                        'province'          => $this->province,
                        'region'            => $this->region,
                        'zip_code'          => $this->zip_code,
                    ],
                    'telephone_no' => $this->telephone_no,
                    'website'      => $this->website_socmed,
                    'member_dob'   => $this->member_dob?->toDateString(),
                    'email'        => $this->email,
                    'tin_no'       => $this->tin_no,
                ],

                'official_representative' => [
                    'first_name'  => $this->rep_first_name,
                    'mid_name'    => $this->rep_mid_name,
                    'surname'     => $this->rep_surname,
                    'designation' => $this->rep_designation,
                    'dob'         => $this->rep_dob?->toDateString(),
                    'contact_no'  => $this->rep_contact_no,
                ],

                'alternate_representative' => [
                    'first_name'  => $this->alt_first_name,
                    'mid_name'    => $this->alt_mid_name,
                    'surname'     => $this->alt_surname,
                    'designation' => $this->alt_designation,
                    'dob'         => $this->alt_dob?->toDateString(),
                    'contact_no'  => $this->alt_contact_no,
                ],

                'organization_membership' => [
                    'name_of_organization' => $this->name_of_organization,
                    'registration_number'  => $this->registration_number,
                    'date_of_registration' => $this->date_of_registration?->toDateString(),
                    'type_of_company'      => $this->type_of_company,
                    'number_of_employees'  => $this->number_of_employees,
                    'year_established'     => $this->year_established,
                ],

                'business_additional_data' => [
                    'industry' => $this->industry,
                    'about_description' => $this->about_description,
                    'business_tagline' => $this->business_tagline,
                    'business_hours' => $this->business_hours,
                    'tags' => $this->tags,
                ],

                'internal_tracking' => [
                    'recommending_approval' => $this->recommending_approval,
                ],

                'timestamps' => [
                    'created_at' => $this->created_at?->toDateTimeString(),
                    'updated_at' => $this->updated_at?->toDateTimeString(),
                ],
            ];
        }

        // TREASURER
        if ($user->hasRole('treasurer')) {
            return [
                'id' => $this->id,
                'date_submitted'  => $this->date_submitted?->toDateString(),
                'status'          => $this->status,
                'date_approved'   => $this->date_approved?->toDateString(),
                'membership_type' => $this->membership_type,

                'basic_profile' => [
                    'registered_business_name' => $this->registered_business_name,
                    'trade_name'               => $this->trade_name,
                    'email'                    => $this->email,
                ],

                // Proof of Payment (Backblaze Temporary URL)
                'proof_of_payment_url' => $this->getS3Url($this->proof_of_payment_path),

                'internal_tracking' => [
                    'recommending_approval' => $this->recommending_approval,
                ],
            ];
        }

        // MEMBER
        if ($user->hasRole('member')) {
            return [
                'date_submitted'  => $this->date_submitted?->toDateString(),
                'status'          => $this->status,
                'date_approved'   => $this->date_approved?->toDateString(),
                'membership_type' => $this->membership_type,

                // === Backblaze Temporary URLs ===
                'photo_url'         => $this->getS3Url($this->photo_path, 60),
                'mayors_permit_url' => $this->getS3Url($this->mayors_permit_path),
                'dti_sec_url'       => $this->getS3Url($this->dti_sec_path),
                'proof_of_payment_url' => $this->getS3Url($this->proof_of_payment_path),

                'basic_profile' => [
                    'registered_business_name' => $this->registered_business_name,
                    'trade_name'               => $this->trade_name,
                    'business_location' => [
                        'business_address'  => $this->business_address,
                        'city_municipality' => $this->city_municipality,
                        'province'          => $this->province,
                        'region'            => $this->region,
                        'zip_code'          => $this->zip_code,
                        'location_link'     => $this->location_link ?? null,
                    ],
                    'telephone_no' => $this->telephone_no,
                    'website'      => $this->website_socmed,
                    'member_dob'   => $this->member_dob?->toDateString(),
                    'email'        => $this->email,
                    'tin_no'       => $this->tin_no,
                ],

                'official_representative' => [
                    'first_name'  => $this->rep_first_name,
                    'mid_name'    => $this->rep_mid_name,
                    'surname'     => $this->rep_surname,
                    'designation' => $this->rep_designation,
                    'dob'         => $this->rep_dob?->toDateString(),
                    'contact_no'  => $this->rep_contact_no,
                ],

                'alternate_representative' => [
                    'first_name'  => $this->alt_first_name,
                    'mid_name'    => $this->alt_mid_name,
                    'surname'     => $this->alt_surname,
                    'designation' => $this->alt_designation,
                    'dob'         => $this->alt_dob?->toDateString(),
                    'contact_no'  => $this->alt_contact_no,
                ],

                'organization_membership' => [
                    'name_of_organization' => $this->name_of_organization,
                    'registration_number'  => $this->registration_number,
                    'date_of_registration' => $this->date_of_registration?->toDateString(),
                    'type_of_company'      => $this->type_of_company,
                    'number_of_employees'  => $this->number_of_employees,
                    'year_established'     => $this->year_established,
                ],

                'business_additional_data' => [
                    'industry' => $this->industry,
                    'about_description' => $this->about_description,
                    'business_tagline' => $this->business_tagline,
                    'business_hours' => $this->business_hours,
                    'tags' => $this->tags,
                ],

                'internal_tracking' => [
                    'recommending_approval' => $this->recommending_approval,
                ],

                'timestamps' => [
                    'created_at' => $this->created_at?->toDateTimeString(),
                    'updated_at' => $this->updated_at?->toDateTimeString(),
                ],
            ];
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
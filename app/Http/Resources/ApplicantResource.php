<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ApplicantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {   
        $user = $request->user();

        /**
         * PUBLIC (NO AUTH) – applicant view
         * Used by /apply response
         */
        if (!$user) {
            return [
                'id' => $this->id,
                'status' => $this->status,
                'date_submitted' => $this->date_submitted?->toDateString(),
            ];
        }

        if ($user->hasAnyRole(['super_admin', 'admin'])) {
            return [
                'id' => $this->id,

                // === FOR PCCI USE ONLY (Upper Right) ===
                'date_submitted'  => $this->date_submitted?->toDateString(),
                'status'          => $this->status,
                'date_approved'   => $this->date_approved?->toDateString(),
                'membership_type' => $this->membership_type,

                // === PHOTO ===
                // 'photo_url' => $this->photo_path ? asset(Storage::url($this->photo_path)) : null,
                // For public photo
                'photo_url' => $this->photo_path ? asset('storage/' . $this->photo_path) : null,

                // 'photo_url' => $this->photo_path
                //     ? route('applicants.download', ['applicant' => $this->id, 'type' => 'photo'])
                //     : null,

                // === DOCUMENTS ===
                'mayors_permit_url' => $this->mayors_permit_path
                    ? route('applicants.download', ['applicant' => $this->id, 'type' => 'mayors_permit'])
                    : null,

                'dti_sec_url' => $this->dti_sec_path
                    ? route('applicants.download', ['applicant' => $this->id, 'type' => 'dti_sec'])
                    : null,

                // === BASIC PROFILE ===
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

                // === OFFICIAL REPRESENTATIVE TO PCCI ===
                'official_representative' => [
                    'first_name'  => $this->rep_first_name,
                    'mid_name'    => $this->rep_mid_name,
                    'surname'     => $this->rep_surname,
                    'designation' => $this->rep_designation,
                    'dob'         => $this->rep_dob?->toDateString(),
                    'contact_no'  => $this->rep_contact_no,
                ],

                // === ALTERNATE REPRESENTATIVE ===
                'alternate_representative' => [
                    'first_name'  => $this->alt_first_name,
                    'mid_name'    => $this->alt_mid_name,
                    'surname'     => $this->alt_surname,
                    'designation' => $this->alt_designation,
                    'dob'         => $this->alt_dob?->toDateString(),
                    'contact_no'  => $this->alt_contact_no,
                ],

                // === MEMBERSHIP IN OTHER BUSINESS ORGANIZATION ===
                'organization_membership' => [
                    'name_of_organization' => $this->name_of_organization,
                    'registration_number'  => $this->registration_number,
                    'date_of_registration' => $this->date_of_registration?->toDateString(),
                    'type_of_company'      => $this->type_of_company,
                    'number_of_employees'  => $this->number_of_employees,
                    'year_established'     => $this->year_established,
                ],

                // === PCCI-VALENZUELA CITY USE ONLY ===
                'internal_tracking' => [
                    'recommending_approval' => $this->recommending_approval,
                ],

                'timestamps' => [
                    'created_at' => $this->created_at?->toDateTimeString(),
                    'updated_at' => $this->updated_at?->toDateTimeString(),
                ],
            ];
        }

        if ($user->hasRole('treasurer')) {
            return [
                'id' => $this->id,

                // === FOR PCCI USE ONLY (Upper Right) ===
                'date_submitted'  => $this->date_submitted?->toDateString(),
                'status'          => $this->status,
                'date_approved'   => $this->date_approved?->toDateString(),
                'membership_type' => $this->membership_type,

                // === BASIC PROFILE ===
                'basic_profile' => [
                    'registered_business_name' => $this->registered_business_name,
                    'trade_name'               => $this->trade_name,
                    'email'                    => $this->email,
                ],

                // === PCCI-VALENZUELA CITY USE ONLY ===
                'internal_tracking' => [
                    'recommending_approval' => $this->recommending_approval,
                ],
            ];
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}

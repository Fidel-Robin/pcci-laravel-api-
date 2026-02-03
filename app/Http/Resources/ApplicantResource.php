<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,

            //===FOR PCCI USE ONLY (Upper Right)===
            'date_submitted'    => $this->date_submitted?->toDateString(),
            'status'  => $this->status,
            'date_approved'     => $this->date_approved?->toDateString() ?? null,
            'membership_type'   => $this->membership_type ?? null,

            // PHOTO
            'photo_url'         => $this->photo ? asset('storage/' . $this->photo) : null,

            /// === BASIC PROFILE (Including Address) ===
            'basic_profile' => [
                'first_name'            => $this->first_name,
                'middle_name'           => $this->middle_name,
                'surname'               => $this->surname,
                'trade_name'            => $this->trade_name,
                
                // Nested Address following the order of rules
                'business_address' => [
                    'house_number'      => $this->business_house_number,
                    'street'            => $this->business_street,
                    'subdivision'       => $this->business_subdivision,
                    'barangay'          => $this->business_barangay,
                    'city_municipality' => $this->city_municipality,
                    'province'          => $this->province,
                    'region'            => $this->region,
                    'zip_code'          => $this->zip_code,
                ],
                
                'telephone_no'          => $this->telephone_no,
                'website'               => $this->website,
                'dob'                   => $this->dob?->toDateString(),
                'email'                 => $this->email,
                'tin_no'                => $this->tin_no,
            ],

            // OFFICIAL REPRESENTATIVE
            'official_representative' => [
                'title'         => $this->rep_title,
                'first_name'    => $this->rep_first_name,
                'mi'            => $this->rep_mi,
                'surname'       => $this->rep_surname,
                'designation'   => $this->rep_designation,
                'dob'           => $this->rep_dob?->toDateString(),
                'contact_no'    => $this->rep_contact_no,
                'signature'     => $this->rep_signature_path ? asset('storage/' . $this->rep_signature_path) : null,
            ],

            // ALTERNATE REPRESENTATIVE
            'alternate_representative' => [
                'title'         => $this->alt_rep_title,
                'first_name'    => $this->alt_first_name,
                'mi'            => $this->alt_mi,
                'surname'       => $this->alt_surname,
                'designation'   => $this->alt_designation,
                'dob'           => $this->alt_dob?->toDateString(),
                'contact_no'    => $this->alt_contact_no,
                'signature'     => $this->alt_signature_path ? asset('storage/' . $this->alt_signature_path) : null,
            ],

            // ORGANIZATION DETAILS
            'organization' => [
                'trade_name'           => $this->trade_name,
                'form_of_organization' => $this->form_of_organization,
                'registration_type'    => $this->registration_type,
                'registration_number'  => $this->registration_number,
                'date_of_registration' => $this->date_of_registration?->toDateString(),
                'type_of_company'      => $this->type_of_company,
                'number_of_employees'  => $this->number_of_employees,
                'year_established'     => $this->year_established,
                'business_line'        => $this->business_line,
                'other_organizations'  => $this->other_organizations,
            ],

            // PCCI-VALENZUELA INTERNAL
            'internal_tracking' => [
                'referred_by'           => $this->referred_by,
                'recommending_approval' => $this->recommending_approval,
            ],

            'timestamps' => [
                'created_at' => $this->created_at?->toDateTimeString(),
                'updated_at' => $this->updated_at?->toDateTimeString(),
            ],
        ];
    }
}
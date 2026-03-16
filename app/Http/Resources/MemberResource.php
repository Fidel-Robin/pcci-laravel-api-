<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'applicant' => [
                'id' => $this->applicant?->id,
                'email' => $this->applicant?->email,
                'registered_business_name' => $this->applicant?->registered_business_name,
                
                // Address Breakdown
                'address' => [
                    'business_address' => $this->applicant?->business_address,
                    'city_municipality' => $this->applicant?->city_municipality,
                    'province' => $this->applicant?->province,
                    'region' => $this->applicant?->region,
                    'zip_code' => $this->applicant?->zip_code,
                ],
                'rep_contact_no' => $this->applicant?->rep_contact_no,
                'representative' => [
                    'first_name' => $this->applicant?->rep_first_name,
                    'mid_name' => $this->applicant?->rep_mid_name,
                    'surname' => $this->applicant?->rep_surname,
                ],
                
            ],
            'membership_type_id' => $this->membership_type_id,
            'induction_date' => $this->induction_date,
            'membership_end_date' => $this->membership_end_date,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ];
    }
}

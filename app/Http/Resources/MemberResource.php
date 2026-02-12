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
            // 'applicant_id' => $this->applicant_id,
            'membership_type_id' => $this->membership_type_id,
            'induction_date' => $this->induction_date,
            'membership_end_date' => $this->membership_end_date,
            'status' => $this->status,
            'created_at' => $this->created_at,
            
            'applicant' => [
                'id' => $this->applicant?->id,
                'email' => $this->applicant?->email,
                'registered_business_name' => $this->applicant?->registered_business_name,
            ],
            
        ];
    }
}

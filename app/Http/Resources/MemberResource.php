<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'membership_no'   => $this->membership_no,
            'membership_type' => $this->membership_type,
            'status'          => $this->status,
            'activated_at'    => $this->activated_at,
            'expires_at'      => $this->expires_at,
            'paid_at'         => $this->paid_at,
            'receipt_no'      => $this->receipt_no,

            'applicant' => [
                'id' => $this->applicant->id,
                'registered_business_name' =>
                    $this->applicant->registered_business_name,
            ],
        ];
    }
}

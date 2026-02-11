<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'applicant' => [
                'id' => $this->applicant?->id,
                'name' => $this->applicant?->registered_business_name,
            ],
            'membership_type' => [
                'id' => $this->membershipType?->id,
                'name' => $this->membershipType?->name,
            ],
            'or_number' => $this->or_number,
            'amount' => $this->amount,
            'received_by' => [
                'id' => $this->receivedBy?->id,
                'name' => $this->receivedBy?->name,
            ],
            'payment_date' => $this->payment_date,
            'created_at' => $this->created_at,
        ];
    }
}

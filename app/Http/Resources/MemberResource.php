<?php

namespace App\Http\Resources;
use App\Http\Resources\ApplicantResource;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            // 👇 reuse applicant resource
            'applicant' => new ApplicantResource($this->whenLoaded('applicant')),

            'membership_type_id' => $this->membership_type_id,
            'induction_date' => $this->induction_date,
            'membership_end_date' => $this->membership_end_date,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ];
    }
}
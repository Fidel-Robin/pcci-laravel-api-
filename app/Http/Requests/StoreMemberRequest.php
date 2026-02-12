<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'applicant_id' => 'required|exists:applicants,id',
            'membership_type_id' => 'nullable|exists:membership_types,id',
            'induction_date' => 'nullable|date',

            // 'membership_end_date' => 'required|date|after:induction_date',
            // 'status' => 'required|in:active,inactive,expired',
        ];
    }
}

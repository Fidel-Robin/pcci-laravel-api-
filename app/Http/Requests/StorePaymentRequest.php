<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // you can add role checking later
    }

    public function rules(): array
    {
        return [
            'applicant_id' => 'required|exists:applicants,id',
            'membership_type_id' => 'required|exists:membership_types,id',
        ];
    }

}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Applicant;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'applicant_id' => [
                'required',
                'exists:applicants,id',
                'unique:payments,applicant_id', // prevents duplicate payment
                function ($attribute, $value, $fail) {
                    $applicant = Applicant::find($value);

                    if ($applicant && $applicant->status !== 'approved') {
                        $fail('Payment can only be created for approved applicants.');
                    }
                }
            ],

            'membership_type_id' => 'required|exists:membership_types,id',
        ];
    }
}

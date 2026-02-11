<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'applicant_id' => 'sometimes|exists:applicants,id',
            'membership_type_id' => 'sometimes|exists:membership_types,id',
            'or_number' => 'sometimes|string|unique:payments,or_number,' . $this->payment,
            'amount' => 'sometimes|numeric|min:0',
            'received_by_user_id' => 'sometimes|exists:users,id',
            'payment_date' => 'sometimes|date',
        ];
    }

}

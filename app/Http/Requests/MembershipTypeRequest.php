<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MembershipTypeRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Set to true if no auth logic yet
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_in_months' => 'required|integer|min:1',
            'renewal_price' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ];
    }
}

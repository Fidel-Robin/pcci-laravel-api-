<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOwnApplicantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('member');
    }

    public function rules(): array
    {
        return [
            'registered_business_name' => 'nullable|string|max:255',
            'trade_name' => 'nullable|string|max:255',
            'business_address' => 'nullable|string|max:255',
            'city_municipality' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:10',
            'telephone_no' => 'nullable|string|max:25',
            'website_socmed' => 'nullable|string|max:255',
            'rep_first_name' => 'nullable|string|max:255',
            'rep_mid_name' => 'nullable|string|max:255',
            'rep_surname' => 'nullable|string|max:255',
            'rep_designation' => 'nullable|string|max:255',
            'rep_contact_no' => 'nullable|string|max:25',
            'alt_first_name' => 'nullable|string|max:255',
            'alt_mid_name' => 'nullable|string|max:255',
            'alt_surname' => 'nullable|string|max:255',
            'alt_designation' => 'nullable|string|max:255',
            'alt_contact_no' => 'nullable|string|max:25',
            'photo' => 'nullable|image|max:2048',
            'mayors_permit' => 'nullable|file|mimes:pdf|max:4096',
            'dti_sec' => 'nullable|file|mimes:pdf|max:4096',
        ];
    }
}

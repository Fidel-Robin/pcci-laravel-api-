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

            // BASIC PROFILE
            'registered_business_name' => 'sometimes|string|max:255',
            'trade_name' => 'sometimes|nullable|string|max:255',

            'business_address' => 'sometimes|string|max:255',
            'city_municipality' => 'sometimes|string|max:255',
            'province' => 'sometimes|string|max:255',
            'region' => 'sometimes|string|max:255',
            'zip_code' => 'sometimes|string|max:10',

            'telephone_no' => 'sometimes|string|max:25',
            'website_socmed' => 'sometimes|nullable|url|max:255',
            'member_dob' => 'sometimes|date',

            'email' => [
                'sometimes',
                'email',
                'unique:applicants,email,' . auth()->user()->member->applicant_id
            ],

            'tin_no' => 'sometimes|nullable|string|max:20',

            // OFFICIAL REP
            'rep_first_name' => 'sometimes|string|max:255',
            'rep_mid_name' => 'sometimes|nullable|string|max:255',
            'rep_surname' => 'sometimes|string|max:255',
            'rep_designation' => 'sometimes|string|max:255',
            'rep_dob' => 'sometimes|date',
            'rep_contact_no' => 'sometimes|string|max:25',

            // ALTERNATE REP
            'alt_first_name' => 'sometimes|string|max:255',
            'alt_mid_name' => 'sometimes|nullable|string|max:255',
            'alt_surname' => 'sometimes|string|max:255',
            'alt_designation' => 'sometimes|string|max:255',
            'alt_dob' => 'sometimes|date',
            'alt_contact_no' => 'sometimes|string|max:25',

            // ORGANIZATION
            'name_of_organization' => 'sometimes|nullable|string|max:500',
            'registration_number' => 'sometimes|string|max:100',
            'date_of_registration' => 'sometimes|date',

            'type_of_company' => 'sometimes|in:Corporation,Partnership,Single Proprietorship',

            'number_of_employees' => 'sometimes|integer|min:0',

            'year_established' => 'sometimes|digits:4|integer|min:1800|max:' . date('Y'),

            // FILES
            'photo' => 'sometimes|image|mimes:jpg,jpeg,png|max:2048',
            'mayors_permit' => 'sometimes|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'dti_sec' => 'sometimes|file|mimes:pdf,jpg,jpeg,png|max:5120',

        ];
    }
}

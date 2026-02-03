<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApplicantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            //===FOR PCCI USE ONLY (Upper Right)===
            'date_submitted'            => 'nullable|date',     //server controlled
            'status'         => 'in:pending,approved,rejected', //server controlled
            'date_approved'             => 'nullable|date',     //server controlled
            'membership_type'           => 'nullable|in:Charter,Life,Regular,Local Chamber,Trade/Industry Association,Affiliate',  //set by the admin  

            // ===PHOTO===
            'photo'                     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            // ===BASIC PROFILE===
            'registered_business_name'  => 'required|string|max:255',
            'trade_name'                => 'nullable|string|max:255',
            //location details
            'business_address'         => 'required|string|max:255',
            'city_municipality'         => 'required|string|max:255',
            'province'                  => 'required|string|max:255',
            'region'                    => 'required|string|max:255',
            'zip_code'                  => 'required|string|max:10',    
            'telephone_no'              => 'required|string|max:25',
            'website_socmed'            => 'nullable|url|max:255',
            'member_dob'               => 'required|date', //this is for review
            'email'                     => 'required|email|unique:applicants,email',
            'tin_no'                    => 'nullable|string|max:20',

            // ===OFFICIAL REPRESENTATIVE TO PCCI===
            'rep_first_name'            => 'required|string|max:255',
            'rep_mid_name'              => 'nullable|string|max:255',
            'rep_surname'               => 'required|string|max:255',
            'rep_designation'           => 'required|string|max:255',
            'rep_dob'                   => 'required|date',
            'rep_contact_no'            => 'required|string|max:25',

            // ===ALTERNATE REPRESENTATIVE/S===                            //==========is this one alternative or can be multiple?==========
            // If they later ask for 5 alternates, you would switch to an array: alt_reps.*.first_name
            'alt_first_name'            => 'required|string|max:255',
            'alt_mid_name'              => 'nullable|string|max:255',
            'alt_surname'               => 'required|string|max:255',
            'alt_designation'           => 'required|string|max:255',
            'alt_dob'                   => 'required|date',
            'alt_contact_no'            => 'required|string|max:25',

            // ===MEMBERSHIP IN OTHER BUSINESS ORGANIZATION===      //==========is this one organization or can be multiple?==========
            'name_of_organization'      => 'nullable|string|max:500', 
            'registration_number'       => 'required|string|max:100',  //can be DTI or SEC number
            'date_of_registration'      => 'required|date',
            'type_of_company'           => 'required|in:Corporation,Partnership,Single Proprietorship',
            'number_of_employees'       => 'required|integer|min:0',
            'year_established'          => 'required|digits:4|integer|min:1800|max:'.date('Y'),

            // ===FOR PCCI-VALENZUELA CITY USE ONLY===
            'recommending_approval' => 'nullable|string|max:255', //this is the user admin who approved the applicant
        ];
    }
}

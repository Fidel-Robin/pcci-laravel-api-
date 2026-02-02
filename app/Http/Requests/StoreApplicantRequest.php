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
            'date_submitted'            => 'required|date',
            'date_approved'             => 'nullable|date',
            'membership_type'           => 'required|in:Charter,Life,Regular,Local Chamber,Trade/Industry Association,Affiliate',

            // ===PHOTO===
            'photo'                     => 'required|image|mimes:jpg,jpeg,png|max:2048', // Passport Size

            // ===BASIC PROFILE===
            'applicant_first_name'      => 'required|string|max:255',
            'applicant_middle_name'     => 'required|string|max:255',
            'applicant_surname'         => 'required|string|max:255',
            'trade_name'                => 'nullable|string|max:255',
            //in place of business address
            'business_house_number'     => 'nullable|string|max:100',
            'business_street'           => 'nullable|string|max:255',
            'business_subdivision'      => 'nullable|string|max:255',
            'business_barangay'         => 'required|string|max:255',
            // house number, street, subdivision, barangay
            'city_municipality'         => 'required|string|max:255',
            'province'                  => 'required|string|max:255',
            'region'                    => 'required|string|max:255',
            'zip_code'                  => 'required|string|max:10',
            'telephone_no'              => 'required|string|max:25',
            'website'                   => 'nullable|url|max:255',
            'applicant_dob'             => 'required|date',
            'email'                     => 'required|email|unique:applicants,email',
            'tin_no'                    => 'required|string|max:20',

            // ===OFFICIAL REPRESENTATIVE TO PCCI===
            'rep_title'                 => 'nullable|string|max:50', // Mr./Ms./Dr.
            'rep_first_name'            => 'required|string|max:255',
            'rep_mi'                    => 'nullable|string|max:2',
            'rep_surname'               => 'required|string|max:255',
            'rep_designation'           => 'required|string|max:255',
            'rep_dob'                   => 'required|date',
            'rep_contact_no'            => 'required|string|max:25',
            'rep_signature_path'        => 'nullable|string',

            // ===ALTERNATE REPRESENTATIVE/S===                            //==========is this one alternative or can be multiple?==========
            // If they later ask for 5 alternates, you would switch to an array: alt_reps.*.first_name
            'alt_rep_title'             => 'nullable|string|max:50', // Mr./Ms./Dr.  
            'alt_first_name'            => 'required|string|max:255',
            'alt_mi'                    => 'nullable|string|max:2',
            'alt_surname'               => 'required|string|max:255',
            'alt_designation'           => 'required|string|max:255',
            'alt_dob'                   => 'required|date',
            'alt_contact_no'            => 'required|string|max:25',
            'alt_signature_path'        => 'nullable|string',

            // ===MEMBERSHIP IN OTHER BUSINESS ORGANIZATION===      //==========is this one organization or can be multiple?==========
            'other_organizations'       => 'nullable|string|max:500', 

            // ===FORM OF ORGANIZATION & SIZE===
            'form_of_organization'      => 'required|in:Corporation,Partnership,Single Proprietorship',
            'registration_type'         => 'required|in:SEC,DTI',                                                        
            'registration_number'       => 'required|string|max:100',  //can be DTI or SEC number
            'date_of_registration'      => 'required|date',
            'type_of_company'           => 'required|in:Corporation,Partnership,Single Proprietorship',
            'number_of_employees'       => 'required|integer|min:0',
            'year_established'          => 'required|digits:4|integer|min:1800|max:'.date('Y'),

            // ===BUSINESS LINE===
            'business_line'             => 'required|string|max:500',

            // ===CERTIFICATION (Signature section)===
            // 'certifier_position'        => 'nullable|in:Chairman,President,Official Representative',
            // 'certifier_other_position'  => 'nullable|string|max:100',
            // 'certifier_name'            => 'nullable|string|max:255',
            // 'certification_date'        => 'nullable|date',

            // ===FOR PCCI-VALENZUELA CITY USE ONLY===
            'referred_by'=> 'nullable|string|max:255',
            'recommending_approval' => 'nullable|string|max:255', //this is the user admin who approved the applicant
            'approved_by' => 'nullable|string|max:255', //this is the president who will approved the applicant (final approval)
        ];
    }
}

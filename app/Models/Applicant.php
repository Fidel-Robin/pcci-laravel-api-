<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $table = 'applicants';

    protected $fillable = [
        // === PCCI USE ONLY ===
        'date_submitted',
        'status',
        'date_approved',
        'membership_type',

        // === PHOTO ===
        'photo', 

        // === BASIC PROFILE ===
        'first_name',
        'middle_name',
        'surname',
        'trade_name',
        'business_house_number',
        'business_street',
        'business_subdivision',
        'business_barangay',
        'city_municipality',
        'province',
        'region',
        'zip_code',
        'telephone_no',
        'website',
        'dob',
        'email',
        'tin_no',

        // === OFFICIAL REPRESENTATIVE ===
        'rep_title',
        'rep_first_name',
        'rep_mi',
        'rep_surname',
        'rep_designation',
        'rep_dob',
        'rep_contact_no',
        'rep_signature_path',

        // === ALTERNATE REPRESENTATIVE ===
        'alt_rep_title',
        'alt_first_name',
        'alt_mi',
        'alt_surname',
        'alt_designation',
        'alt_dob',
        'alt_contact_no',
        'alt_signature_path',

        // === OTHER ORGANIZATIONS ===
        'other_organizations',

        // === FORM OF ORGANIZATION & SIZE ===
        'form_of_organization',
        'registration_type',
        'registration_number',
        'date_of_registration',
        'type_of_company',
        'number_of_employees',
        'year_established',

        // === BUSINESS LINE ===
        'business_line',

        // === INTERNAL TRACKING ===
        'referred_by',
        'recommending_approval',
    ];

    /**
     * The model's default values for attributes.
     */
    protected $attributes = [
        'status' => 'pending',
    ];

    /**
     * If you want to treat dates as Carbon objects automatically
     */
    protected $casts = [
        'dob' => 'date',
        'rep_dob' => 'date',
        'alt_dob' => 'date',
        'date_submitted' => 'date',
        'date_approved' => 'date',
        'date_of_registration' => 'date',
    ];
}
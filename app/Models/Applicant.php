<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $table = 'applicants';

    protected $fillable = [
        // === FOR PCCI USE ONLY ===
        'date_submitted',
        'status',
        'date_approved',
        'membership_type',

        // === PHOTO ===
        'photo',

        // === BASIC PROFILE ===
        'registered_business_name',
        'trade_name',
        'business_address',
        'city_municipality',
        'province',
        'region',
        'zip_code',
        'telephone_no',
        'website_socmed',
        'member_dob',
        'email',
        'tin_no',

        // === OFFICIAL REPRESENTATIVE TO PCCI ===
        'rep_first_name',
        'rep_mid_name',
        'rep_surname',
        'rep_designation',
        'rep_dob',
        'rep_contact_no',

        // === ALTERNATE REPRESENTATIVE ===
        'alt_first_name',
        'alt_mid_name',
        'alt_surname',
        'alt_designation',
        'alt_dob',
        'alt_contact_no',

        // === MEMBERSHIP IN OTHER BUSINESS ORGANIZATION ===
        'name_of_organization',
        'registration_number',
        'date_of_registration',
        'type_of_company',
        'number_of_employees',
        'year_established',

        // === FOR PCCI-VALENZUELA CITY USE ONLY ===
        'recommending_approval',
    ];

    /**
     * Default attribute values
     */
    protected $attributes = [
        'status' => 'pending',
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'member_dob' => 'date',
        'rep_dob' => 'date',
        'alt_dob' => 'date',
        'date_submitted' => 'date',
        'date_approved' => 'date',
        'date_of_registration' => 'date',
        'number_of_employees' => 'integer',
        'year_established' => 'integer',
    ];

    public function member()
    {
        return $this->hasOne(Member::class);
    }

}

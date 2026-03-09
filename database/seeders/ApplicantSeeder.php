<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Applicant;
use Carbon\Carbon;

class ApplicantSeeder extends Seeder
{
    public function run(): void
    {
        $applicants = [
            [
                'registered_business_name' => 'Alvarez Park Café',
                'trade_name' => 'N/A',
                'business_address' => 'N/A',
                'city_municipality' => 'N/A',
                'province' => 'N/A',
                'region' => 'N/A',
                'zip_code' => '0000',
                'telephone_no' => 'N/A',
                'website_socmed' => 'N/A',
                'member_dob' => Carbon::parse('2000-01-01'),
                'email' => 'alvarez1@example.com', // must be unique
                'tin_no' => 'N/A',
                
                'rep_first_name' => 'Remigio',
                'rep_mid_name' => 'N/A',
                'rep_surname' => 'Alvarez',
                'rep_designation' => 'N/A',
                'rep_dob' => Carbon::parse('1980-01-01'),
                'rep_contact_no' => '09565105198',
                
                'alt_first_name' => 'N/A',
                'alt_mid_name' => 'N/A',
                'alt_surname' => 'N/A',
                'alt_designation' => 'N/A',
                'alt_dob' => Carbon::parse('2000-01-01'),
                'alt_contact_no' => 'N/A',
                
                'name_of_organization' => 'N/A',
                'registration_number' => 'N/A',
                'date_of_registration' => Carbon::parse('2000-01-01'),
                'type_of_company' => 'Single Proprietorship',
                'number_of_employees' => 0,
                'year_established' => 2000,
                
                'photo_path' => 'N/A',
                'mayors_permit_path' => 'N/A',
                'dti_sec_path' => 'N/A',
                'proof_of_payment_path' => 'N/A',
                'recommending_approval' => 'N/A',
                'status' => 'paid',
                'date_submitted' => Carbon::parse('2000-01-01'),

                //
            ],
            [
                'registered_business_name' => 'Alvarez22 Park Café',
                'trade_name' => 'N/A',
                'business_address' => 'N/A',
                'city_municipality' => 'N/A',
                'province' => 'N/A',
                'region' => 'N/A',
                'zip_code' => '0000',
                'telephone_no' => 'N/A',
                'website_socmed' => 'N/A',
                'member_dob' => Carbon::parse('2000-01-01'),
                'email' => 'alvarez2@example.com', // must be unique
                'tin_no' => 'N/A',
                
                'rep_first_name' => 'Remigio',
                'rep_mid_name' => 'N/A',
                'rep_surname' => 'Alvarez',
                'rep_designation' => 'N/A',
                'rep_dob' => Carbon::parse('1980-01-01'),
                'rep_contact_no' => '09565105198',
                
                'alt_first_name' => 'N/A',
                'alt_mid_name' => 'N/A',
                'alt_surname' => 'N/A',
                'alt_designation' => 'N/A',
                'alt_dob' => Carbon::parse('2000-01-01'),
                'alt_contact_no' => 'N/A',
                
                'name_of_organization' => 'N/A',
                'registration_number' => 'N/A',
                'date_of_registration' => Carbon::parse('2000-01-01'),
                'type_of_company' => 'Single Proprietorship',
                'number_of_employees' => 0,
                'year_established' => 2000,
                
                'photo_path' => 'N/A',
                'mayors_permit_path' => 'N/A',
                'dti_sec_path' => 'N/A',
                'proof_of_payment_path' => 'N/A',
                'recommending_approval' => 'N/A',
                'status' => 'paid',
                'date_submitted' => Carbon::parse('2000-01-01'),

                //
            ],
            // Add the rest similarly...
        ];

        foreach ($applicants as $applicant) {
            Applicant::create($applicant);
        }

        $this->command->info('Applicants table seeded successfully!');
    }
}
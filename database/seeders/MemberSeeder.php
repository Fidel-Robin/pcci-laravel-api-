<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Applicant;
use App\Models\Member;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        // Get all existing applicants
        $applicants = Applicant::all();

        foreach ($applicants as $applicant) {
            // Create a member for each applicant
            Member::create([
                'applicant_id' => $applicant->id,
                'user_id' => null, // assign later if you have a corresponding user
                'membership_type_id' => 1, // default, change if you have multiple types
                'induction_date' => now(),
                'membership_end_date' => now()->addYear(), // example: 1-year membership
                'status' => 'active', // or 'pending' depending 
            ]);
        }

        $this->command->info('Members table seeded successfully!');
    }
}
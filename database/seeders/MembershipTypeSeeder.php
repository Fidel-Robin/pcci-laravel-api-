<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MembershipType;

class MembershipTypeSeeder extends Seeder
{
    public function run(): void
    {
        MembershipType::create([
            'name' => 'Micro',
            'price' => 500,
            'duration_in_months' => 12,
            'renewal_price' => null,
            'notes' => '1-year membership only',
        ]);

        MembershipType::create([
            'name' => 'Small Enterprises',
            'price' => 5000,
            'duration_in_months' => 12,
            'renewal_price' => 3000,
            'notes' => 'Initial fee P5,000, renewal P3,000',
        ]);
    }
}

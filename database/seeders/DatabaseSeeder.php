<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            MembershipTypeSeeder::class,
            RoleSeeder::class,
            SuperAdminSeeder::class,

            ApplicantSeeder::class,
            MemberSeeder::class,
            UserMemberSeeder::class,
        ]);
    }
}
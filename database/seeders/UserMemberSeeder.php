<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UserMemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = Member::with('applicant')->get();

        $credentials = [];

        // foreach ($members as $index => $member) {

        //     $email = $member->applicant->email ?? 'user' . $member->id . '@example.com';

        //     // First record uses password123, others random
        //     $password = $index === 0 ? 'password123' : Str::random(11);

        //     // Create user
        //     $user = User::create([
        //         'name' => $member->applicant->registered_business_name,
        //         'email' => $email,
        //         'password' => Hash::make($password),
        //     ]);

        //     $user->assignRole('member');

        //     $member->update([
        //         'user_id' => $user->id,
        //     ]);

        //     $credentials[] = "Business: {$user->name} | Email: {$email} | Password: {$password}";
        // }

        foreach ($members as $member) {

            $email = $member->applicant->email ?? 'user' . $member->id . '@example.com';

            // Generate consistent password per user
            $password = substr(md5($email), 0, 10);

            $user = User::create([
                'name' => $member->applicant->registered_business_name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);

            $user->assignRole('member');

            $member->update([
                'user_id' => $user->id,
            ]);

            $credentials[] = "Business: {$user->name} | Email: {$email} | Password: {$password}";
        }

        // Save credentials to file
        File::put(
            storage_path('app/member_credentials.txt'),
            implode("\n", $credentials)
        );

        $this->command->info('Users seeded successfully.');
        $this->command->info('Credentials saved to storage/app/member_credentials.txt');
    }
}
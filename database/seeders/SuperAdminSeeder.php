<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Make sure the role exists
        $role = Role::firstOrCreate(['name' => 'super_admin']);

        // Create or get the super admin user
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@pcci.test'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'), // dev only
            ]
        );

        // Assign role if not already assigned
        if (!$superAdmin->hasRole('super_admin')) {
            $superAdmin->assignRole($role);
        }

        $this->command->info('Super Admin user is ready!');
        $this->command->info('Email: admin@pcci.test');
        $this->command->info('Password: password');
    }
}

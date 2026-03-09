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
        // Ensure roles exist
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $treasurerRole = Role::firstOrCreate(['name' => 'treasurer']);

        // SUPER ADMIN
        $superAdmin = User::firstOrCreate(
            ['email' => 'super_admin@pcci.test'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
            ]
        );
        $superAdmin->syncRoles([$superAdminRole]);

        // ADMIN
        $admin = User::firstOrCreate(
            ['email' => 'admin2@pcci.test'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );
        $admin->syncRoles([$adminRole]);

        // TREASURER
        $treasurer = User::firstOrCreate(
            ['email' => 'treasurer@pcci.test'],
            [
                'name' => 'Treasurer User',
                'password' => Hash::make('password'),
            ]
        );
        $treasurer->syncRoles([$treasurerRole]);

        $this->command->info('Users seeded successfully!');
        $this->command->line('');

        $this->command->info('Super Admin Credentials:');
        $this->command->line('Email: super_admin@pcci.test');
        $this->command->line('Password: password');
        $this->command->line('');

        $this->command->info('Admin Credentials:');
        $this->command->line('Email: admin@pcci.test');
        $this->command->line('Password: password');
        $this->command->line('');

        $this->command->info('Treasurer Credentials:');
        $this->command->line('Email: treasurer@pcci.test');
        $this->command->line('Password: password');

    }
}
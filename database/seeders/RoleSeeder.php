<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Clear cached roles/permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions
        Permission::firstOrCreate(['name' => 'view applicants']);
        Permission::firstOrCreate(['name' => 'create applicants']);
        Permission::firstOrCreate(['name' => 'edit applicants']);
        Permission::firstOrCreate(['name' => 'delete applicants']);

        // Roles
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdmin->givePermissionTo([
            'view applicants',
            'create applicants',
            'edit applicants',
            'delete applicants'
        ]);

        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'treasurer']);
        Role::firstOrCreate(['name' => 'data_encoder']);
        Role::firstOrCreate(['name' => 'member']);
    }
}

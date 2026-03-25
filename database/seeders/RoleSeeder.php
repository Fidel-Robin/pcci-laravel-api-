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
        $permissions = ['view applicants','create applicants','edit applicants','delete applicants'];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission],
                ['guard_name' => 'sanctum'] // ✅ assign guard
            );
        }

        // Roles
        $superAdmin = Role::firstOrCreate(
            ['name' => 'super_admin'],
            ['guard_name' => 'sanctum'] // ✅ assign guard
        );
        $superAdmin->givePermissionTo($permissions);

        Role::firstOrCreate(['name' => 'admin'], ['guard_name' => 'sanctum']);
        Role::firstOrCreate(['name' => 'treasurer'], ['guard_name' => 'sanctum']);
        Role::firstOrCreate(['name' => 'data_encoder'], ['guard_name' => 'sanctum']);
        Role::firstOrCreate(['name' => 'member'], ['guard_name' => 'sanctum']);
    }
}
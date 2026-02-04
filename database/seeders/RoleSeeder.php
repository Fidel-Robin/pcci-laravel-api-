<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions for applicants
        Permission::create(['name' => 'view applicants']);
        Permission::create(['name' => 'create applicants']);
        Permission::create(['name' => 'edit applicants']);
        Permission::create(['name' => 'delete applicants']);

        // Create super_admin role and assign all permissions
        $role = Role::create(['name' => 'super_admin']);
        $role->givePermissionTo([
            'view applicants',
            'create applicants',
            'edit applicants',
            'delete applicants'
        ]);
    }
}
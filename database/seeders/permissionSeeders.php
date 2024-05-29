<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class permissionSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        //Data Master
        Permission::create(['name' => 'view_permissions', 'guard_name' => 'web']);
        Permission::create(['name' => 'create_permissions', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete_permissions', 'guard_name' => 'web']);

        Permission::create(['name' => 'view_roles', 'guard_name' => 'web']);
        Permission::create(['name' => 'create_roles', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit_roles', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete_roles', 'guard_name' => 'web']);

        Permission::create(['name' => 'view_users', 'guard_name' => 'web']);
        Permission::create(['name' => 'create_users', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit_users', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete_users', 'guard_name' => 'web']);

        // Management
        Permission::create(['name' => 'view_regions', 'guard_name' => 'web']);
        Permission::create(['name' => 'create_regions', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete_regions', 'guard_name' => 'web']);

        Permission::create(['name' => 'view_offices', 'guard_name' => 'web']);
        Permission::create(['name' => 'create_offices', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit_offices', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete_offices', 'guard_name' => 'web']);

        // Mine Management
        Permission::create(['name' => 'view_mines', 'guard_name' => 'web']);
        Permission::create(['name' => 'create_mines', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit_mines', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete_mines', 'guard_name' => 'web']);

        // Vehicle Management
        Permission::create(['name' => 'view_vehicles', 'guard_name' => 'web']);
        Permission::create(['name' => 'create_vehicles', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit_vehicles', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete_vehicles', 'guard_name' => 'web']);

        // Employee Management
        Permission::create(['name' => 'view_employees', 'guard_name' => 'web']);
        Permission::create(['name' => 'create_employees', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit_employees', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete_employees', 'guard_name' => 'web']);

        // Booking Management
        Permission::create(['name' => 'view_bookings', 'guard_name' => 'web']);
        Permission::create(['name' => 'create_bookings', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit_bookings', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete_bookings', 'guard_name' => 'web']);
        Permission::create(['name' => 'approve_bookings', 'guard_name' => 'web']);
        Permission::create(['name' => 'reject_bookings', 'guard_name' => 'web']);

        // Approval Management
        Permission::create(['name' => 'view_approvals', 'guard_name' => 'web']);
        Permission::create(['name' => 'create_approvals', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit_approvals', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete_approvals', 'guard_name' => 'web']);

        // Usage History Management
        Permission::create(['name' => 'view_usage_history', 'guard_name' => 'web']);
        Permission::create(['name' => 'create_usage_history', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit_usage_history', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete_usage_history', 'guard_name' => 'web']);

        $userRole = Role::first();

        $userRole->givePermissionTo([
            'view_permissions', 
            'create_permissions', 
            'delete_permissions',
            'view_roles',
            'create_roles',
            'edit_roles',
            'delete_roles',
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
            'view_regions',
            'create_regions',
            'delete_regions',
            'view_offices',
            'create_offices',
            'edit_offices',
            'delete_offices',
            'view_mines',
            'create_mines',
            'edit_mines',
            'delete_mines',
            'view_vehicles',
            'create_vehicles',
            'edit_vehicles',
            'delete_vehicles',
            'view_employees',
            'create_employees',
            'edit_employees',
            'delete_employees',
            'view_bookings',
            'create_bookings',
            'edit_bookings',
            'delete_bookings',
            'approve_bookings',
            'reject_bookings',
            'view_approvals',
            'create_approvals',
            'edit_approvals',
            'delete_approvals',
            'view_usage_history',
            'create_usage_history',
            'edit_usage_history',
            'delete_usage_history',
        ]);

        $user = User::factory()->create([
            'name'       => 'Admin',
            'email'      => 'admin@gmail.com',
            'password'   => Hash::make('password'),
            'created_at' => now(),
        ]);

        $user->assignRole($userRole);

        $userRoleApproval = Role::where('id', 2)->first();

        $userRoleApproval->givePermissionTo([
            'view_vehicles',
            'create_vehicles',
            'edit_vehicles',
            'delete_vehicles',
            'view_employees',
            'create_employees',
            'edit_employees',
            'delete_employees',
            'view_bookings',
            'create_bookings',
            'edit_bookings',
            'delete_bookings',
            'approve_bookings',
            'reject_bookings',
            'view_approvals',
            'create_approvals',
            'edit_approvals',
            'delete_approvals',
            'view_usage_history',
            'create_usage_history',
            'edit_usage_history',
            'delete_usage_history',
        ]);

        $userApproval = User::factory()->create([
            'name'       => 'John Doe',
            'email'      => 'johndoe@gmail.com',
            'password'   => Hash::make('password'),
            'created_at' => now(),
        ]);

        $userApproval->assignRole($userRoleApproval);
    }
}

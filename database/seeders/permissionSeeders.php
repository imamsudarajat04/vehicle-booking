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

        // Region and Office Management
        Permission::create(['name' => 'view_regions', 'guard_name' => 'web']);
        Permission::create(['name' => 'create_regions', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit_regions', 'guard_name' => 'web']);
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

        // Vehicle Type Management
        Permission::create(['name' => 'view_vehicle_types', 'guard_name' => 'web']);
        Permission::create(['name' => 'create_vehicle_types', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit_vehicle_types', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete_vehicle_types', 'guard_name' => 'web']);

        // Booking Management
        Permission::create(['name' => 'view_bookings', 'guard_name' => 'web']);
        Permission::create(['name' => 'create_bookings', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit_bookings', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete_bookings', 'guard_name' => 'web']);
        Permission::create(['name' => 'approve_bookings', 'guard_name' => 'web']);

        // Approval Management
        Permission::create(['name' => 'view_approvals', 'guard_name' => 'web']);
        Permission::create(['name' => 'create_approvals', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit_approvals', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete_approvals', 'guard_name' => 'web']);

        // Fuel Consumption Management
        Permission::create(['name' => 'view_fuel_consumption', 'guard_name' => 'web']);
        Permission::create(['name' => 'create_fuel_consumption', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit_fuel_consumption', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete_fuel_consumption', 'guard_name' => 'web']);

        // Service Schedule Management
        Permission::create(['name' => 'view_service_schedules', 'guard_name' => 'web']);
        Permission::create(['name' => 'create_service_schedules', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit_service_schedules', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete_service_schedules', 'guard_name' => 'web']);

        // Usage History Management
        Permission::create(['name' => 'view_usage_history', 'guard_name' => 'web']);
        Permission::create(['name' => 'create_usage_history', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit_usage_history', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete_usage_history', 'guard_name' => 'web']);

        $userRole = Role::first();

        $userRole->givePermissionTo('view_regions');
        $userRole->givePermissionTo('create_regions');
        $userRole->givePermissionTo('edit_regions');
        $userRole->givePermissionTo('delete_regions');
        $userRole->givePermissionTo('view_offices');
        $userRole->givePermissionTo('create_offices');
        $userRole->givePermissionTo('edit_offices');
        $userRole->givePermissionTo('delete_offices');
        $userRole->givePermissionTo('view_mines');
        $userRole->givePermissionTo('create_mines');
        $userRole->givePermissionTo('edit_mines');
        $userRole->givePermissionTo('delete_mines');
        $userRole->givePermissionTo('view_vehicles');
        $userRole->givePermissionTo('create_vehicles');
        $userRole->givePermissionTo('edit_vehicles');
        $userRole->givePermissionTo('delete_vehicles');
        $userRole->givePermissionTo('view_vehicle_types');
        $userRole->givePermissionTo('create_vehicle_types');
        $userRole->givePermissionTo('edit_vehicle_types');
        $userRole->givePermissionTo('delete_vehicle_types');
        $userRole->givePermissionTo('view_bookings');
        $userRole->givePermissionTo('create_bookings');
        $userRole->givePermissionTo('edit_bookings');
        $userRole->givePermissionTo('delete_bookings');
        $userRole->givePermissionTo('approve_bookings');
        $userRole->givePermissionTo('view_approvals');
        $userRole->givePermissionTo('create_approvals');
        $userRole->givePermissionTo('edit_approvals');
        $userRole->givePermissionTo('delete_approvals');
        $userRole->givePermissionTo('view_fuel_consumption');
        $userRole->givePermissionTo('create_fuel_consumption');
        $userRole->givePermissionTo('edit_fuel_consumption');
        $userRole->givePermissionTo('delete_fuel_consumption');
        $userRole->givePermissionTo('view_service_schedules');
        $userRole->givePermissionTo('create_service_schedules');
        $userRole->givePermissionTo('edit_service_schedules');
        $userRole->givePermissionTo('delete_service_schedules');
        $userRole->givePermissionTo('view_usage_history');
        $userRole->givePermissionTo('create_usage_history');
        $userRole->givePermissionTo('edit_usage_history');
        $userRole->givePermissionTo('delete_usage_history');

        $user = User::factory()->create([
            'name'       => 'Admin',
            'email'      => 'admin@gmail.com',
            'password'   => Hash::make('password'),
            'created_at' => now(),
        ]);

        $user->assignRole($userRole);
    }
}

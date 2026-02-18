<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        $superAdmin = Role::create(['name' => 'super_admin']);
        $manager = Role::create(['name' => 'manager']);
        $salesStaff = Role::create(['name' => 'sales_staff']);
        $inventoryStaff = Role::create(['name' => 'inventory_staff']);
        $dealer = Role::create(['name' => 'dealer']);
        $customer = Role::create(['name' => 'customer']);

        // Create permissions
        $permissions = [
            'view_products',
            'create_products',
            'edit_products',
            'delete_products',
            'view_orders',
            'create_orders',
            'edit_orders',
            'delete_orders',
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
            'view_dealers',
            'approve_dealers',
            'view_reports',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign all permissions to super admin
        $superAdmin->givePermissionTo(Permission::all());

        // Assign specific permissions to other roles
        $manager->givePermissionTo([
            'view_products', 'create_products', 'edit_products',
            'view_orders', 'create_orders', 'edit_orders',
            'view_users', 'view_dealers', 'approve_dealers',
            'view_reports',
        ]);

        $salesStaff->givePermissionTo([
            'view_products', 'view_orders', 'create_orders', 'edit_orders',
        ]);

        $inventoryStaff->givePermissionTo([
            'view_products', 'edit_products',
        ]);
    }
}

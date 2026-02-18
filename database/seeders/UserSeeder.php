<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@chamakchemical.com',
            'password' => Hash::make('password'),
            'phone' => '+92300123456',
            'language_preference' => 'en',
            'is_active' => true,
        ]);
        $superAdmin->assignRole('super_admin');

        // Manager
        $manager = User::create([
            'name' => 'Manager',
            'email' => 'manager@chamakchemical.com',
            'password' => Hash::make('password'),
            'phone' => '+92300123457',
            'language_preference' => 'en',
            'is_active' => true,
        ]);
        $manager->assignRole('manager');

        // Sales Staff
        $sales = User::create([
            'name' => 'Sales Person',
            'email' => 'sales@chamakchemical.com',
            'password' => Hash::make('password'),
            'phone' => '+92300123458',
            'language_preference' => 'en',
            'is_active' => true,
        ]);
        $sales->assignRole('sales_staff');

        // Inventory Staff
        $inventory = User::create([
            'name' => 'Inventory Manager',
            'email' => 'inventory@chamakchemical.com',
            'password' => Hash::make('password'),
            'phone' => '+92300123459',
            'language_preference' => 'en',
            'is_active' => true,
        ]);
        $inventory->assignRole('inventory_staff');

        // Test Customers
        for ($i = 1; $i <= 5; $i++) {
            $customer = User::create([
                'name' => "Customer $i",
                'email' => "customer$i@example.com",
                'password' => Hash::make('password'),
                'phone' => '+9230012345' . (60 + $i),
                'language_preference' => $i % 2 == 0 ? 'ur' : 'en',
                'is_active' => true,
            ]);
            $customer->assignRole('customer');
        }
    }
}

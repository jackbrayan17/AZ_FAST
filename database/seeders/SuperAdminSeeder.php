<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        // Find the Super Admin role
        $role = Role::where('name', 'Super Admin')->first();

        // Create the Super Admin user
        User::create([
            'name' => 'Super Admin',
            'username' => 'superadmin', // Add this line
            'phone' => '123456789',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin', // Assign Super Admin role
            'role_id' => 1, // Ensure this corresponds to an existing role ID
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class RoleUserSeeder extends Seeder
{
    public function run()
    {
        // Define roles
        $roles = ['admin', 'tenant', 'landlord'];
        
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['role_name' => $roleName]);
        }

        // Define users with their role
        $users = [
            ['name' => 'Admin User', 'email' => 'admin@example.com', 'role' => 'admin'],
            ['name' => 'Tenant User', 'email' => 'tenant@example.com', 'role' => 'tenant'],
            ['name' => 'Landlord User', 'email' => 'landlord@example.com', 'role' => 'landlord'],
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                ['name' => $userData['name'], 'password' => Hash::make('123456')]
            );

            $role = Role::where('role_name', $userData['role'])->first();

            // Attach role to user if not already attached
            $user->roles()->syncWithoutDetaching([$role->id]);
        }
    }
}

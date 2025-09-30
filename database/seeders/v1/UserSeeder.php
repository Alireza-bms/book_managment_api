<?php

namespace Database\Seeders\v1;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles if not exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $librarianRole = Role::firstOrCreate(['name' => 'librarian']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Users data
        $usersData = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => 'password',
                'role' => $adminRole,
            ],
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => 'password',
                'role' => $userRole,
            ],
        ];

        foreach ($usersData as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']], // unique field
                [
                    'name' => $data['name'],
                    'password' => $data['password'],
                ]
            );

            // Assign role
            if (!$user->hasRole($data['role']->name)) {
                $user->assignRole($data['role']);
            }
        }
    }
}

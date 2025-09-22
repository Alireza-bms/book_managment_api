<?php

namespace Database\Seeders\v1;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed users using unique email instead of ID.
     */
    public function run(): void
    {
        $usersData = [
            ['name' => 'Admin User', 'email' => 'admin@example.com', 'password' => 'password'],
            ['name' => 'John Doe', 'email' => 'john@example.com', 'password' => 'password'],
        ];

        foreach ($usersData as $data) {
            User::updateOrCreate(
                ['email' => $data['email']], // unique field
                ['name' => $data['name'], 'password' => $data['password']] // hashed automatically
            );
        }
    }
}

<?php

namespace Database\Seeders\v1;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = include database_path('data/v1/users.php');


        foreach ($users as $userData) {
            $roles = $userData['roles'] ?? [];
            unset($userData['roles']);

            $user = User::create($userData);
            if (!empty($roles)) {
                $user->roles()->attach($roles);
            }
        }
    }
}

<?php

namespace Database\Seeders\v1;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = include database_path('data/v1/roles.php');

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}

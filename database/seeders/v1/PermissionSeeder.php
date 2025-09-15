<?php

namespace Database\Seeders\v1;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = include database_path('data/v1/permissions.php');

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}

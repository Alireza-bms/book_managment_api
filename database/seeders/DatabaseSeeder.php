<?php

namespace Database\Seeders;

use Database\Seeders\v1\{
    AuthorSeeder,
    BookSeeder,
    CategorySeeder,
    LoanSeeder,
    UserSeeder,
    RolePermissionSeeder
};
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            AuthorSeeder::class,
            BookSeeder::class,
            LoanSeeder::class,
        ]);
    }
}

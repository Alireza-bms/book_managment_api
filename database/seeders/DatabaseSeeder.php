<?php

namespace Database\Seeders;

use Database\Seeders\v1\{
    AuthorSeeder,
    BookSeeder,
    CategorySeeder,
    LoanSeeder,
    PermissionSeeder,
    RoleSeeder,
    UserSeeder
};
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            AuthorSeeder::class,
            BookSeeder::class,
            LoanSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders\v1;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Seed categories using unique name.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Science', 'description' => 'Science books'],
            ['name' => 'Fiction', 'description' => 'Fiction books'],
        ];

        foreach ($categories as $data) {
            Category::updateOrCreate(
                ['name' => $data['name']], // unique field
                $data
            );
        }
    }
}

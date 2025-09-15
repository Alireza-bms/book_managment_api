<?php

namespace Database\Seeders\v1;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = include database_path('data/v1/categories.php');


        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

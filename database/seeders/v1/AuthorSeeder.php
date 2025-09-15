<?php

namespace Database\Seeders\v1;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = include database_path('data/v1/authors.php');


        foreach ($authors as $author) {
            Author::create($author);
        }
    }
}

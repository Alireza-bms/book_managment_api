<?php

namespace Database\Seeders\v1;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Seed authors using unique name.
     */
    public function run(): void
    {
        $authors = [
            ['name' => 'Isaac Asimov', 'bio' => 'Sci-fi writer'],
            ['name' => 'J.K. Rowling', 'bio' => 'Fantasy writer'],
        ];

        foreach ($authors as $data) {
            Author::updateOrCreate(
                ['name' => $data['name']], // unique field
                $data
            );
        }
    }
}

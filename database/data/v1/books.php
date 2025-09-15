<?php
return [
    [
        'title' => 'The Hobbit',
        'isbn' => '9780261103344',
        'published_year' => 1937,
        'category_id' => 1, // Fantasy
        'total_copies' => 5,
        'available_copies' => 5,
        'description' => 'A fantasy novel by J.R.R. Tolkien.',
        'authors' => [1],
    ],
    [
        'title' => 'Foundation',
        'isbn' => '9780553293357',
        'published_year' => 1951,
        'category_id' => 2, // Science Fiction
        'total_copies' => 4,
        'available_copies' => 4,
        'description' => 'A science fiction novel by Isaac Asimov.',
        'authors' => [2],
    ],
    [
        'title' => '1984',
        'isbn' => '9780451524935',
        'published_year' => 1949,
        'category_id' => 2, // Science Fiction / Dystopia
        'total_copies' => 3,
        'available_copies' => 3,
        'description' => 'A dystopian novel by George Orwell.',
        'authors' => [3],
    ],
    [
        'title' => 'Murder on the Orient Express',
        'isbn' => '9780062073501',
        'published_year' => 1934,
        'category_id' => 3, // Mystery
        'total_copies' => 2,
        'available_copies' => 2,
        'description' => 'A detective novel by Agatha Christie.',
        'authors' => [4],
    ],
    [
        'title' => 'Good Omens',
        'isbn' => '9780060853983',
        'published_year' => 1990,
        'category_id' => 1, // Fantasy (example with multiple authors)
        'total_copies' => 2,
        'available_copies' => 2,
        'description' => 'A comedic fantasy by Neil Gaiman & Terry Pratchett (we attach two example authors for demo).',
        'authors' => [1, 2], // demo: attach existing authors (ok for testing)
    ],
];

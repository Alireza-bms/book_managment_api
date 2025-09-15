<?php
return [
    // Alice borrows The Hobbit (book_id = 1)
    [
        'user_id' => 1,
        'book_id' => 1,
        'loaned_at' => '2025-08-01',
        'due_at' => '2025-08-15',
        'returned_at' => '2025-08-10',
    ],
    // Liam borrows Foundation (book_id = 2), not yet returned
    [
        'user_id' => 2,
        'book_id' => 2,
        'loaned_at' => '2025-09-01',
        'due_at' => '2025-09-15',
        'returned_at' => null,
    ],
    // User U borrows 1984 (book_id = 3), returned late
    [
        'user_id' => 3,
        'book_id' => 3,
        'loaned_at' => '2025-07-10',
        'due_at' => '2025-07-24',
        'returned_at' => '2025-08-01',
    ],
];

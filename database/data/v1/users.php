<?php
return [
    [
        'name' => 'Alice Admin',
        'email' => 'alice@example.test',
        'password' => 'password', // Model casts password => 'hashed' می‌تونه اینو هش کنه
        'roles' => [1], // admin
    ],
    [
        'name' => 'Liam Librarian',
        'email' => 'liam@example.test',
        'password' => 'password',
        'roles' => [2], // librarian
    ],
    [
        'name' => 'User U',
        'email' => 'user@example.test',
        'password' => 'password',
        'roles' => [3], // user
    ],
];

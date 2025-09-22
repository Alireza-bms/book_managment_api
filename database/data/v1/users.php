<?php
return [
    [
        'name' => 'Alice Admin',
        'email' => 'alice@example.test',
        'password' => 'password', // hashed automatically by model cast
        'roles' => ['admin'],     // roles by name
    ],
    [
        'name' => 'Liam Librarian',
        'email' => 'liam@example.test',
        'password' => 'password',
        'roles' => ['librarian'],
    ],
    [
        'name' => 'User U',
        'email' => 'user@example.test',
        'password' => 'password',
        'roles' => ['user'],
    ],
];

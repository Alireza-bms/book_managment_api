<?php
return [
    [
        'name' => 'Alice Admin',
        'email' => 'alice@gmail.com',
        'password' => 'password', // hashed automatically by model cast
        'roles' => ['admin'],     // roles by name
    ],
    [
        'name' => 'Liam Librarian',
        'email' => 'liam@gmail.com',
        'password' => 'password',
        'roles' => ['librarian'],
    ],
    [
        'name' => 'User U',
        'email' => 'user@gmail.com',
        'password' => 'password',
        'roles' => ['user'],
    ],
];

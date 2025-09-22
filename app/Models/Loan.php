<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'loaned_at',
        'due_at',
        'returned_at',
        'status'
    ];

    protected $casts = [
        'loaned_at' => 'datetime',
        'due_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    // many-to-one → Loan ↔ User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // many-to-one → Loan ↔ Book
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loan extends Model
{
    use HasFactory ,SoftDeletes;

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

    // Cache tags that should be flushed when this model is created, updated, or deleted
    public static array $relatedCacheTags = ['loans','users', 'books'];


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

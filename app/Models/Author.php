<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = ['name', 'bio'];

    // Cache tags that should be flushed when this model is created, updated, or deleted
    public static array $relatedCacheTags = ['categories', 'books', 'authors'];

    // many-to-many → Author ↔ Book
    public function books()
    {
        return $this->belongsToMany(Book::class)
            ->withTimestamps();
    }
}


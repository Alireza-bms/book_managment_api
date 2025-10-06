<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'isbn',
        'published_year',
        'total_copies',
        'available_copies'
    ];

    // Cache tags that should be flushed when this model is created, updated, or deleted
    public static array $relatedCacheTags = ['categories', 'books', 'authors'];


    // many-to-many → Book ↔ Author
    public function authors()
    {
        return $this->belongsToMany(Author::class)
            ->withTimestamps();
    }

    // one-to-many → Book ↔ Loan
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    // many-to-one → Book ↔ Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}


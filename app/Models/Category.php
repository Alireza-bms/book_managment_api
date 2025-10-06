<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,softDeletes;

    protected $fillable = ['name','description'];

    // Cache tags that should be flushed when this model is created, updated, or deleted
    public static array $relatedCacheTags = ['categories', 'books','authors'];


    // one-to-many → Category ↔ Books
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}

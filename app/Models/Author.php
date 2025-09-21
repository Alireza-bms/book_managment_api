<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use HasFactory,softDeletes;

    protected $fillable = ['name','bio'];

    // many-to-many → Author ↔ Book
    public function books()
    {
        return $this->belongsToMany(Book::class)
            ->withTimestamps();
    }
}


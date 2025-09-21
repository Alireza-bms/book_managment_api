<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,softDeletes;

    protected $fillable = ['name','description'];

    // one-to-many → Category ↔ Books
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /** @use HasFactory<\Database\Factories\RoleFactory> */
    use HasFactory;

    protected $fillable = ['name', 'description'];

    // many-to-many → Role ↔ User
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps();
    }

    // many-to-many → Role ↔ Permission
    public function permissions()
    {
        return $this->belongsToMany(Permission::class)
            ->withTimestamps();
    }
}


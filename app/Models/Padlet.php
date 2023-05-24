<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Padlet extends Model
{
    protected $fillable = ['name', 'published', 'ispublic'];

    public function findid() : bool {
        return $this->id = 1;
    }
    // Padlet has many entries
    public function entries() : HasMany
    {
        return $this->hasMany(Entry::class);
    }
    // Padlet has many users
    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}


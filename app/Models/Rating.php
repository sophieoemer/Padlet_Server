<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    use HasFactory;
    protected $fillable = ['rating', 'comment', 'username', 'entry_id'];

    public function entry(): BelongsTo{
        return $this->belongsTo(Entry::class);
    }
}

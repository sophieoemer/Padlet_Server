<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Entry extends Model
{
    use HasFactory;
    protected $fillable = [
        'textEntry',
        'padlet_id'
    ];
    /**
     * padlet has many entries
     */
    public function padlet() : BelongsTo
    {
        return $this->belongsTo(Padlet::class);
    }
    // entry has mani ratings
    public function ratings() : HasMany
    {
        return $this->hasMany(Rating::class);
    }

}

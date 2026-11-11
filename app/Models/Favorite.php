<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;


class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'favorable_id',
        'favorable_type',
    ];

    /**
     * Relación con el usuario que marcó el favorito.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación polimórfica (puede ser Character, Location o Episode).
     */
    public function favorable(): MorphTo
    {
        return $this->morphTo();
    }
}

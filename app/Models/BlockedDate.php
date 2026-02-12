<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlockedDate extends Model
{
    protected $fillable = [
        'date',
        'reason',
        'created_by',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Get the user who created this blocked date.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope to filter by a specific date.
     */
    public function scopeForDate($query, $date)
    {
        return $query->whereDate('date', $date);
    }

    /**
     * Check if a given date is blocked.
     */
    public static function isBlocked(Carbon $date): bool
    {
        return static::whereDate('date', $date->toDateString())->exists();
    }
}

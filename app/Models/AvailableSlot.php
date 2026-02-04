<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailableSlot extends Model
{
    protected $fillable = [
        'start_time',
        'end_time',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available')
                     ->where('start_time', '>', now())
                     ->orderBy('start_time', 'asc');
    }
}

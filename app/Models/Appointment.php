<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable = [
        'user_id',
        'vehicle_id',
        'name',
        'email',
        'phone',
        'vehicle',
        'service',
        'notes',
        'admin_notes',
        'appointment_date',
        'appointment_end',
        'status',
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
        'appointment_end' => 'datetime',
    ];
    
    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'admin_notes', // Don't expose admin notes in API responses
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PendingAppointment extends Model
{
    protected $fillable = [
        'user_id',
        'available_slot_id',
        'vehicle_id',
        'name',
        'email',
        'phone',
        'vehicle',
        'service',
        'notes',
        'status',
        'admin_notes',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function availableSlot(): BelongsTo
    {
        return $this->belongsTo(AvailableSlot::class);
    }

    public function vehicleDetails(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
}

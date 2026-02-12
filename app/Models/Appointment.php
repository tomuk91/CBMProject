<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\AvailableSlot;

class Appointment extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'available_slot_id',
        'vehicle_id',
        'name',
        'email',
        'phone',
        'vehicle_description',
        'service',
        'notes',
        'admin_notes',
        'appointment_date',
        'appointment_end',
        'status',
        'cancellation_requested',
        'cancellation_requested_at',
        'cancellation_reason',
        'booked_by_admin',
        'rescheduled_at',
        'reminder_sent_at',
    ];

    protected $casts = [
        'status' => AppointmentStatus::class,
        'appointment_date' => 'datetime',
        'appointment_end' => 'datetime',
        'cancellation_requested' => 'boolean',
        'cancellation_requested_at' => 'datetime',
        'booked_by_admin' => 'boolean',
        'rescheduled_at' => 'datetime',
        'reminder_sent_at' => 'datetime',
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

    public function availableSlot(): BelongsTo
    {
        return $this->belongsTo(AvailableSlot::class);
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', AppointmentStatus::Confirmed);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', AppointmentStatus::Completed);
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', AppointmentStatus::Cancelled);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('appointment_date', '>=', now())
                     ->whereIn('status', [AppointmentStatus::Confirmed, AppointmentStatus::Pending]);
    }

    public function scopePast($query)
    {
        return $query->where('appointment_date', '<', now());
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeWithCancellationRequest($query)
    {
        return $query->where('cancellation_requested', true);
    }
}

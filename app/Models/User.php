<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'completed_tours',
        'show_help_guides',
        'phone',
        'address',
        'city',
        'postal_code',
        'country',
        'mot_next_due',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'completed_tours' => 'array',
            'show_help_guides' => 'boolean',
        ];
    }

    /**
     * Check if a specific tour page has been completed.
     */
    public function hasCompletedTour(string $page): bool
    {
        return !empty($this->completed_tours[$page]);
    }

    /**
     * Mark a tour page as completed.
     */
    public function completeTour(string $page): void
    {
        $tours = $this->completed_tours ?? [];
        $tours[$page] = true;
        $this->update(['completed_tours' => $tours]);
    }

    /**
     * Reset a tour page so it shows again.
     */
    public function resetTour(string $page): void
    {
        $tours = $this->completed_tours ?? [];
        unset($tours[$page]);
        $this->update(['completed_tours' => $tours]);
    }

    /**
     * Get the appointments for the user.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Get the vehicles for the user.
     */
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    /**
     * Get the user's primary vehicle.
     */
    public function primaryVehicle()
    {
        return $this->hasOne(Vehicle::class)->where('is_primary', true);
    }

    public function pendingAppointments(): HasMany
    {
        return $this->hasMany(PendingAppointment::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    /**
     * Update the MOT next due date based on the most recent completed MOT appointment.
     */
    public function updateMOTNextDue(): void
    {
        $lastMOT = $this->appointments()
            ->where('service', 'MOT Service')
            ->where('status', 'completed')
            ->orderBy('appointment_date', 'desc')
            ->first();

        if ($lastMOT) {
            // Calculate next due date (1 year from completion)
            $nextDue = \Carbon\Carbon::parse($lastMOT->appointment_date)->addYear()->format('Y-m-d');
            $this->update(['mot_next_due' => $nextDue]);
        } else {
            // No MOT found, set to Unknown
            $this->update(['mot_next_due' => 'Unknown']);
        }
    }
}

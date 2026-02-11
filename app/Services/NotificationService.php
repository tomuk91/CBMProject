<?php

namespace App\Services;

use App\Models\Appointment;
use App\Mail\AppointmentReminder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    protected BatchEmailService $batchEmailService;

    public function __construct(BatchEmailService $batchEmailService)
    {
        $this->batchEmailService = $batchEmailService;
    }

    /**
     * Send appointment reminder email
     */
    public function sendAppointmentReminder(Appointment $appointment): bool
    {
        try {
            Mail::to($appointment->email)->queue(new AppointmentReminder($appointment));
            
            Log::info("Appointment reminder sent", [
                'appointment_id' => $appointment->id,
                'email' => $appointment->email,
                'appointment_date' => $appointment->appointment_date->toDateTimeString(),
            ]);
            
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send appointment reminder", [
                'appointment_id' => $appointment->id,
                'error' => $e->getMessage(),
            ]);
            
            return false;
        }
    }

    /**
     * Send bulk reminders for multiple appointments using Resend batch API.
     */
    public function sendBulkReminders(array $appointments): array
    {
        $emails = [];
        foreach ($appointments as $appointment) {
            $emails[] = [
                'to' => $appointment->email,
                'mailable' => new AppointmentReminder($appointment),
            ];
        }

        return $this->batchEmailService->sendBatch($emails);
    }
}

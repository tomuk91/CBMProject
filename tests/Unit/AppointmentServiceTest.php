<?php

namespace Tests\Unit;

use App\Enums\AppointmentStatus;
use App\Enums\SlotStatus;
use App\Mail\AppointmentApproved;
use App\Models\ActivityLog;
use App\Models\Appointment;
use App\Models\AvailableSlot;
use App\Models\PendingAppointment;
use App\Models\User;
use App\Services\AppointmentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AppointmentServiceTest extends TestCase
{
    use RefreshDatabase;

    private AppointmentService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new AppointmentService();
    }

    private function createSlotAndPending(array $slotOverrides = [], array $pendingOverrides = []): array
    {
        $user = User::factory()->create();
        $slot = AvailableSlot::create(array_merge([
            'start_time' => now()->addDays(3)->setHour(10)->setMinute(0),
            'end_time' => now()->addDays(3)->setHour(11)->setMinute(0),
            'status' => SlotStatus::Available,
        ], $slotOverrides));

        $pending = PendingAppointment::create(array_merge([
            'user_id' => $user->id,
            'available_slot_id' => $slot->id,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+36301234567',
            'vehicle' => '2020 Toyota Corolla',
            'service' => 'Oil Change',
            'status' => 'pending',
        ], $pendingOverrides));

        return [$user, $slot, $pending];
    }

    public function test_approve_pending_appointment_creates_appointment_with_correct_data(): void
    {
        Mail::fake();
        [$user, $slot, $pending] = $this->createSlotAndPending();

        // Act as admin for logging
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        $appointment = $this->service->approvePendingAppointment($pending, 'Test admin notes');

        $this->assertInstanceOf(Appointment::class, $appointment);
        $this->assertEquals($user->id, $appointment->user_id);
        $this->assertEquals($slot->id, $appointment->available_slot_id);
        $this->assertEquals('John Doe', $appointment->name);
        $this->assertEquals('john@example.com', $appointment->email);
        $this->assertEquals('Oil Change', $appointment->service);
        $this->assertEquals('Test admin notes', $appointment->admin_notes);
        $this->assertEquals(AppointmentStatus::Confirmed, $appointment->status);
        $this->assertEquals($slot->start_time->format('Y-m-d H:i:s'), $appointment->appointment_date->format('Y-m-d H:i:s'));
    }

    public function test_approve_pending_appointment_marks_slot_as_booked(): void
    {
        Mail::fake();
        [$user, $slot, $pending] = $this->createSlotAndPending();
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        $this->service->approvePendingAppointment($pending);

        $slot->refresh();
        $this->assertEquals(SlotStatus::Booked, $slot->status);
    }

    public function test_approve_pending_appointment_updates_pending_status_to_approved(): void
    {
        Mail::fake();
        [$user, $slot, $pending] = $this->createSlotAndPending();
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        $this->service->approvePendingAppointment($pending, 'Looks good');

        $pending->refresh();
        $this->assertEquals('approved', $pending->status);
        $this->assertEquals('Looks good', $pending->admin_notes);
    }

    public function test_approve_pending_appointment_sends_approval_email(): void
    {
        Mail::fake();
        [$user, $slot, $pending] = $this->createSlotAndPending();
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        $this->service->approvePendingAppointment($pending);

        Mail::assertQueued(AppointmentApproved::class, function (AppointmentApproved $mail) {
            return $mail->appointment->email === 'john@example.com';
        });
    }

    public function test_approve_pending_appointment_throws_if_slot_not_available(): void
    {
        Mail::fake();
        [$user, $slot, $pending] = $this->createSlotAndPending(['status' => SlotStatus::Booked]);
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Slot is no longer available');

        $this->service->approvePendingAppointment($pending);
    }

    public function test_cancel_appointment_soft_deletes_appointment(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        $slot = AvailableSlot::create([
            'start_time' => now()->addDays(3)->setHour(10)->setMinute(0),
            'end_time' => now()->addDays(3)->setHour(11)->setMinute(0),
            'status' => SlotStatus::Booked,
        ]);

        $appointment = Appointment::create([
            'user_id' => $admin->id,
            'available_slot_id' => $slot->id,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+36301234567',
            'vehicle' => '2020 Toyota Corolla',
            'service' => 'Oil Change',
            'appointment_date' => $slot->start_time,
            'appointment_end' => $slot->end_time,
            'status' => AppointmentStatus::Confirmed,
        ]);

        $this->service->cancelAppointment($appointment, 'Customer request');

        $this->assertSoftDeleted('appointments', ['id' => $appointment->id]);
    }

    public function test_cancel_appointment_frees_slot_back_to_available(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        $slot = AvailableSlot::create([
            'start_time' => now()->addDays(3)->setHour(10)->setMinute(0),
            'end_time' => now()->addDays(3)->setHour(11)->setMinute(0),
            'status' => SlotStatus::Booked,
        ]);

        $appointment = Appointment::create([
            'user_id' => $admin->id,
            'available_slot_id' => $slot->id,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+36301234567',
            'vehicle' => '2020 Toyota Corolla',
            'service' => 'Oil Change',
            'appointment_date' => $slot->start_time,
            'appointment_end' => $slot->end_time,
            'status' => AppointmentStatus::Confirmed,
        ]);

        $this->service->cancelAppointment($appointment);

        $slot->refresh();
        $this->assertEquals(SlotStatus::Available, $slot->status);
    }

    public function test_cancel_appointment_logs_activity(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        $slot = AvailableSlot::create([
            'start_time' => now()->addDays(3)->setHour(10)->setMinute(0),
            'end_time' => now()->addDays(3)->setHour(11)->setMinute(0),
            'status' => SlotStatus::Booked,
        ]);

        $appointment = Appointment::create([
            'user_id' => $admin->id,
            'available_slot_id' => $slot->id,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+36301234567',
            'vehicle' => '2020 Toyota Corolla',
            'service' => 'Oil Change',
            'appointment_date' => $slot->start_time,
            'appointment_end' => $slot->end_time,
            'status' => AppointmentStatus::Confirmed,
        ]);

        $this->service->cancelAppointment($appointment, 'No longer needed');

        $this->assertDatabaseHas('activity_logs', [
            'action' => 'cancelled',
            'model_type' => Appointment::class,
            'model_id' => $appointment->id,
        ]);
    }

    public function test_get_appointments_for_reminders_returns_correct_appointments(): void
    {
        $user = User::factory()->create();

        // Appointment 24h from now (should be returned)
        $targetTime = now()->addHours(24);
        Appointment::create([
            'user_id' => $user->id,
            'name' => 'Reminder Target',
            'email' => 'reminder@example.com',
            'phone' => '+36301234567',
            'vehicle' => '2020 Toyota Corolla',
            'service' => 'Oil Change',
            'appointment_date' => $targetTime,
            'appointment_end' => $targetTime->copy()->addHour(),
            'status' => AppointmentStatus::Confirmed,
        ]);

        // Appointment 48h from now (should NOT be returned)
        $farTime = now()->addHours(48);
        Appointment::create([
            'user_id' => $user->id,
            'name' => 'Far Future',
            'email' => 'far@example.com',
            'phone' => '+36301234567',
            'vehicle' => '2020 Honda Civic',
            'service' => 'Brake Check',
            'appointment_date' => $farTime,
            'appointment_end' => $farTime->copy()->addHour(),
            'status' => AppointmentStatus::Confirmed,
        ]);

        // Cancelled appointment 24h from now (should NOT be returned)
        Appointment::create([
            'user_id' => $user->id,
            'name' => 'Cancelled One',
            'email' => 'cancelled@example.com',
            'phone' => '+36301234567',
            'vehicle' => '2020 BMW 3',
            'service' => 'Tire Change',
            'appointment_date' => $targetTime->copy()->addMinutes(5),
            'appointment_end' => $targetTime->copy()->addMinutes(65),
            'status' => AppointmentStatus::Cancelled,
        ]);

        $results = $this->service->getAppointmentsForReminders(24);

        $this->assertCount(1, $results);
        $this->assertEquals('Reminder Target', $results->first()->name);
    }
}

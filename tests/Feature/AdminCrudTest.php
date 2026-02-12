<?php

namespace Tests\Feature;

use App\Enums\AppointmentStatus;
use App\Enums\SlotStatus;
use App\Models\Appointment;
use App\Models\AvailableSlot;
use App\Models\BlockedDate;
use App\Models\ContactSubmission;
use App\Models\PendingAppointment;
use App\Models\ScheduleTemplate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AdminCrudTest extends TestCase
{
    use RefreshDatabase;

    private function createAdmin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }

    private function createSlot(array $overrides = []): AvailableSlot
    {
        return AvailableSlot::create(array_merge([
            'start_time' => now()->addDays(3)->setHour(10)->setMinute(0),
            'end_time' => now()->addDays(3)->setHour(11)->setMinute(0),
            'status' => SlotStatus::Available,
        ], $overrides));
    }

    public function test_admin_can_access_dashboard(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
    }

    public function test_non_admin_cannot_access_admin_routes(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertStatus(403);
    }

    public function test_unauthenticated_user_redirected_to_login(): void
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_approve_pending_appointment(): void
    {
        Mail::fake();
        $admin = $this->createAdmin();
        $user = User::factory()->create();
        $slot = $this->createSlot(['status' => SlotStatus::Pending]);

        $pendingAppointment = PendingAppointment::create([
            'user_id' => $user->id,
            'available_slot_id' => $slot->id,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+36301234567',
            'vehicle' => '2020 Toyota Corolla',
            'service' => 'Oil Change',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.appointments.approve', $pendingAppointment), [
            'admin_notes' => 'Approved by admin',
        ]);

        $response->assertRedirect();

        // Appointment should be created
        $this->assertDatabaseHas('appointments', [
            'user_id' => $user->id,
            'available_slot_id' => $slot->id,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'service' => 'Oil Change',
            'status' => AppointmentStatus::Confirmed->value,
        ]);

        // Slot should be booked
        $slot->refresh();
        $this->assertEquals(SlotStatus::Booked, $slot->status);

        // Pending appointment status updated
        $pendingAppointment->refresh();
        $this->assertEquals('approved', $pendingAppointment->status);
    }

    public function test_admin_can_reject_pending_appointment(): void
    {
        Mail::fake();
        $admin = $this->createAdmin();
        $user = User::factory()->create();
        $slot = $this->createSlot(['status' => SlotStatus::Pending]);

        $pendingAppointment = PendingAppointment::create([
            'user_id' => $user->id,
            'available_slot_id' => $slot->id,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+36301234567',
            'vehicle' => '2020 Toyota Corolla',
            'service' => 'Oil Change',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.appointments.reject', $pendingAppointment), [
            'admin_notes' => 'No availability',
        ]);

        $response->assertRedirect();

        // Pending appointment should be rejected
        $pendingAppointment->refresh();
        $this->assertEquals('rejected', $pendingAppointment->status);

        // Slot should be available again
        $slot->refresh();
        $this->assertEquals(SlotStatus::Available, $slot->status);

        // Mail should have been queued
        Mail::assertQueued(\App\Mail\AppointmentRejected::class);
    }

    public function test_admin_can_create_slot(): void
    {
        $admin = $this->createAdmin();
        $startDate = now()->addDays(5)->format('Y-m-d');
        $startTime = '09:00';

        $response = $this->actingAs($admin)->post(route('admin.appointments.slots.store'), [
            'start_date' => $startDate,
            'start_time' => $startTime,
            'duration' => 60,
            'bulk_type' => 'single',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('available_slots', [
            'status' => SlotStatus::Available->value,
        ]);
    }

    public function test_admin_can_delete_available_slot(): void
    {
        $admin = $this->createAdmin();
        $slot = $this->createSlot();

        $response = $this->actingAs($admin)->delete(route('admin.appointments.slots.destroy', $slot));

        $response->assertRedirect();
        $this->assertDatabaseMissing('available_slots', ['id' => $slot->id]);
    }

    public function test_admin_cannot_delete_booked_slot(): void
    {
        $admin = $this->createAdmin();
        $slot = $this->createSlot(['status' => SlotStatus::Booked]);

        $response = $this->actingAs($admin)->delete(route('admin.appointments.slots.destroy', $slot));

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('available_slots', ['id' => $slot->id]);
    }

    public function test_admin_can_create_schedule_template(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)->post(route('admin.schedule-templates.store'), [
            'name' => 'Monday Morning',
            'day_of_week' => 1,
            'start_time' => '08:00',
            'end_time' => '12:00',
            'slot_duration_minutes' => 60,
            'break_between_minutes' => 15,
            'is_active' => false,
            'max_weeks_ahead' => 4,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('schedule_templates', [
            'name' => 'Monday Morning',
            'day_of_week' => 1,
            'slot_duration_minutes' => 60,
        ]);
    }

    public function test_admin_can_delete_schedule_template(): void
    {
        $admin = $this->createAdmin();

        $template = ScheduleTemplate::create([
            'name' => 'Test Template',
            'day_of_week' => 2,
            'start_time' => '09:00',
            'end_time' => '17:00',
            'slot_duration_minutes' => 60,
            'break_between_minutes' => 15,
            'is_active' => false,
            'max_weeks_ahead' => 4,
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.schedule-templates.destroy', $template));

        $response->assertRedirect();
        $this->assertDatabaseMissing('schedule_templates', ['id' => $template->id]);
    }

    public function test_admin_can_create_blocked_date(): void
    {
        $admin = $this->createAdmin();
        $futureDate = now()->addDays(10)->format('Y-m-d');

        $response = $this->actingAs($admin)->post(route('admin.blocked-dates.store'), [
            'date' => $futureDate,
            'reason' => 'National Holiday',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseCount('blocked_dates', 1);

        $blockedDate = BlockedDate::first();
        $this->assertEquals($futureDate, $blockedDate->date->format('Y-m-d'));
        $this->assertEquals('National Holiday', $blockedDate->reason);
        $this->assertEquals($admin->id, $blockedDate->created_by);
    }

    public function test_admin_can_delete_blocked_date(): void
    {
        $admin = $this->createAdmin();
        $blockedDate = BlockedDate::create([
            'date' => now()->addDays(10)->format('Y-m-d'),
            'reason' => 'Holiday',
            'created_by' => $admin->id,
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.blocked-dates.destroy', $blockedDate));

        $response->assertRedirect();
        $this->assertDatabaseMissing('blocked_dates', ['id' => $blockedDate->id]);
    }

    public function test_admin_can_view_customers_list(): void
    {
        $admin = $this->createAdmin();
        User::factory()->create(['is_admin' => false, 'name' => 'Customer One']);
        User::factory()->create(['is_admin' => false, 'name' => 'Customer Two']);

        $response = $this->actingAs($admin)->get(route('admin.customers.index'));

        $response->assertStatus(200);
    }

    public function test_admin_can_mark_contact_submission_as_read(): void
    {
        $admin = $this->createAdmin();

        $submission = ContactSubmission::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'subject' => 'general_inquiry',
            'message' => 'I have a question about your services.',
            'is_read' => false,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.contact-submissions.mark-read', $submission));

        $response->assertRedirect();

        $submission->refresh();
        $this->assertTrue($submission->is_read);
    }

    public function test_admin_can_delete_appointment(): void
    {
        Mail::fake();
        $admin = $this->createAdmin();
        $slot = $this->createSlot(['status' => SlotStatus::Booked]);

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

        $response = $this->actingAs($admin)->delete(route('admin.appointments.destroy', $appointment));

        $response->assertRedirect();

        // Appointment should be soft-deleted
        $this->assertSoftDeleted('appointments', ['id' => $appointment->id]);

        // Slot should be available again
        $slot->refresh();
        $this->assertEquals(SlotStatus::Available, $slot->status);
    }

    public function test_admin_can_update_appointment_status(): void
    {
        $admin = $this->createAdmin();
        $slot = $this->createSlot(['status' => SlotStatus::Booked]);

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

        $response = $this->actingAs($admin)->post(route('admin.appointments.status', $appointment), [
            'status' => 'completed',
        ]);

        $response->assertRedirect();

        $appointment->refresh();
        $this->assertEquals(AppointmentStatus::Completed, $appointment->status);
    }
}

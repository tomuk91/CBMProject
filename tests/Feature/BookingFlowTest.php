<?php

namespace Tests\Feature;

use App\Enums\AppointmentStatus;
use App\Enums\SlotStatus;
use App\Models\Appointment;
use App\Models\AvailableSlot;
use App\Models\PendingAppointment;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingFlowTest extends TestCase
{
    use RefreshDatabase;

    private function createSlot(array $overrides = []): AvailableSlot
    {
        return AvailableSlot::create(array_merge([
            'start_time' => now()->addDays(3)->setHour(10)->setMinute(0),
            'end_time' => now()->addDays(3)->setHour(11)->setMinute(0),
            'status' => SlotStatus::Available,
        ], $overrides));
    }

    private function createVehicle(User $user, array $overrides = []): Vehicle
    {
        return Vehicle::create(array_merge([
            'user_id' => $user->id,
            'make' => 'Toyota',
            'model' => 'Corolla',
            'year' => 2020,
            'plate' => 'ABC-123',
        ], $overrides));
    }

    public function test_user_can_view_available_slots_page(): void
    {
        $user = User::factory()->create();
        $this->createSlot();

        $response = $this->actingAs($user)->get(route('appointments.index'));

        $response->assertStatus(200);
    }

    public function test_user_can_book_an_appointment_creates_pending_appointment(): void
    {
        $user = User::factory()->create();
        $slot = $this->createSlot();
        $vehicle = $this->createVehicle($user);

        $response = $this->actingAs($user)->post(route('appointments.store', $slot), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+36301234567',
            'vehicle_id' => $vehicle->id,
            'service' => 'Oil Change',
            'notes' => 'Please check brakes too',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('pending_appointments', [
            'user_id' => $user->id,
            'available_slot_id' => $slot->id,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'service' => 'Oil Change',
            'status' => 'pending',
        ]);

        // Slot should be marked as pending after booking
        $slot->refresh();
        $this->assertEquals(SlotStatus::Pending, $slot->status);
    }

    public function test_user_cannot_book_slot_that_is_already_booked(): void
    {
        $user = User::factory()->create();
        $slot = $this->createSlot(['status' => SlotStatus::Booked]);

        $response = $this->actingAs($user)->post(route('appointments.store', $slot), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+36301234567',
            'service' => 'Oil Change',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseMissing('pending_appointments', [
            'available_slot_id' => $slot->id,
        ]);
    }

    public function test_user_cannot_book_slot_that_is_pending(): void
    {
        $user = User::factory()->create();
        $slot = $this->createSlot(['status' => SlotStatus::Pending]);

        $response = $this->actingAs($user)->post(route('appointments.store', $slot), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+36301234567',
            'service' => 'Oil Change',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseMissing('pending_appointments', [
            'user_id' => $user->id,
            'available_slot_id' => $slot->id,
            'status' => 'pending',
        ]);
    }

    public function test_user_can_request_cancellation_of_confirmed_appointment(): void
    {
        $user = User::factory()->create();
        $slot = $this->createSlot(['status' => SlotStatus::Booked]);

        $appointment = Appointment::create([
            'user_id' => $user->id,
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

        $response = $this->actingAs($user)->post(route('appointments.requestCancellation', $appointment), [
            'cancellation_reason' => 'I have a schedule conflict',
        ]);

        $response->assertRedirect();

        $appointment->refresh();
        $this->assertTrue($appointment->cancellation_requested);
        $this->assertEquals('I have a schedule conflict', $appointment->cancellation_reason);
    }

    public function test_user_cannot_request_cancellation_of_already_cancelled_appointment(): void
    {
        $user = User::factory()->create();
        $slot = $this->createSlot();

        $appointment = Appointment::create([
            'user_id' => $user->id,
            'available_slot_id' => $slot->id,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+36301234567',
            'vehicle' => '2020 Toyota Corolla',
            'service' => 'Oil Change',
            'appointment_date' => $slot->start_time,
            'appointment_end' => $slot->end_time,
            'status' => AppointmentStatus::Cancelled,
        ]);

        $response = $this->actingAs($user)->post(route('appointments.requestCancellation', $appointment), [
            'cancellation_reason' => 'I want to cancel',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');

        $appointment->refresh();
        $this->assertFalse((bool) $appointment->cancellation_requested);
    }

    public function test_cancellation_request_sets_flag_and_stores_reason(): void
    {
        $user = User::factory()->create();
        $slot = $this->createSlot(['status' => SlotStatus::Booked]);

        $appointment = Appointment::create([
            'user_id' => $user->id,
            'available_slot_id' => $slot->id,
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '+36301234567',
            'vehicle' => '2021 Honda Civic',
            'service' => 'Brake Inspection',
            'appointment_date' => $slot->start_time,
            'appointment_end' => $slot->end_time,
            'status' => AppointmentStatus::Confirmed,
        ]);

        $this->actingAs($user)->post(route('appointments.requestCancellation', $appointment), [
            'cancellation_reason' => 'Moving to another city',
        ]);

        $appointment->refresh();
        $this->assertTrue($appointment->cancellation_requested);
        $this->assertEquals('Moving to another city', $appointment->cancellation_reason);
        $this->assertNotNull($appointment->cancellation_requested_at);
    }

    public function test_user_can_view_appointment_details(): void
    {
        $user = User::factory()->create();
        $slot = $this->createSlot(['status' => SlotStatus::Booked]);

        $appointment = Appointment::create([
            'user_id' => $user->id,
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

        $response = $this->actingAs($user)->get(route('appointments.details', $appointment));

        $response->assertStatus(200);
    }

    public function test_user_cannot_view_other_users_appointment_details(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $slot = $this->createSlot(['status' => SlotStatus::Booked]);

        $appointment = Appointment::create([
            'user_id' => $otherUser->id,
            'available_slot_id' => $slot->id,
            'name' => 'Other User',
            'email' => 'other@example.com',
            'phone' => '+36301234567',
            'vehicle' => '2020 Toyota Corolla',
            'service' => 'Oil Change',
            'appointment_date' => $slot->start_time,
            'appointment_end' => $slot->end_time,
            'status' => AppointmentStatus::Confirmed,
        ]);

        $response = $this->actingAs($user)->get(route('appointments.details', $appointment));

        $response->assertStatus(403);
    }

    public function test_unauthenticated_user_cannot_book_appointment(): void
    {
        $slot = $this->createSlot();

        $response = $this->post(route('appointments.store', $slot), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+36301234567',
            'service' => 'Oil Change',
        ]);

        $response->assertRedirect(route('login'));
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\AvailableSlot;
use App\Models\PendingAppointment;
use Illuminate\Foundation\Testing\RefreshDatabase;use Illuminate\Support\Facades\Mail;use Tests\TestCase;

class AppointmentBookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_available_slots()
    {
        $user = User::factory()->create();
        
        // Create available slots
        AvailableSlot::create([
            'start_time' => now()->addDay(),
            'end_time' => now()->addDay()->addHour(),
            'status' => 'available',
        ]);

        $response = $this->actingAs($user)->get(route('appointments.index'));

        $response->assertStatus(200);
    }

    public function test_user_can_book_appointment()
    {
        Mail::fake();
        
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
        ]);

        $vehicle = \App\Models\Vehicle::create([
            'user_id' => $user->id,
            'make' => 'Toyota',
            'model' => 'Camry',
            'year' => 2020,
            'license_plate' => 'ABC123',
            'is_primary' => true,
        ]);

        $slot = AvailableSlot::create([
            'start_time' => now()->addDay(),
            'end_time' => now()->addDay()->addHour(),
            'status' => 'available',
        ]);

        $response = $this->withoutExceptionHandling()->actingAs($user)->post(route('appointments.store', $slot), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'vehicle_id' => $vehicle->id,
            'service' => 'Oil Change',
            'notes' => 'Please call before arrival',
        ]);

        // Should redirect to confirmation
        $response->assertRedirect(route('appointments.confirmation'));
        
        // Check pending appointment was created
        $this->assertDatabaseCount('pending_appointments', 1);
    }

    public function test_user_can_request_cancellation()
    {
        $user = User::factory()->create();

        $appointment = \App\Models\Appointment::create([
            'user_id' => $user->id,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'service' => 'Oil Change',
            'vehicle' => '2020 Toyota Camry',
            'appointment_date' => now()->addDays(3),
            'appointment_end' => now()->addDays(3)->addHour(),
            'status' => 'confirmed',
        ]);

        $response = $this->actingAs($user)->post(
            route('appointments.requestCancellation', $appointment),
            ['cancellation_reason' => 'Change of plans']
        );

        $response->assertRedirect();
        
        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'cancellation_requested' => true,
        ]);
    }
}

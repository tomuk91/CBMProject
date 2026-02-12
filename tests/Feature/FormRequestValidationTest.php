<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FormRequestValidationTest extends TestCase
{
    use RefreshDatabase;

    /*
    |--------------------------------------------------------------------------
    | StoreAppointmentRequest Validation
    |--------------------------------------------------------------------------
    */

    public function test_store_appointment_requires_name(): void
    {
        $user = User::factory()->create();
        $slot = \App\Models\AvailableSlot::create([
            'start_time' => now()->addDays(3)->setHour(10)->setMinute(0),
            'end_time' => now()->addDays(3)->setHour(11)->setMinute(0),
            'status' => \App\Enums\SlotStatus::Available,
        ]);

        $response = $this->actingAs($user)->post(route('appointments.store', $slot), [
            'email' => 'john@example.com',
            'phone' => '+36301234567',
            'service' => 'Oil Change',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_store_appointment_requires_email(): void
    {
        $user = User::factory()->create();
        $slot = \App\Models\AvailableSlot::create([
            'start_time' => now()->addDays(3)->setHour(10)->setMinute(0),
            'end_time' => now()->addDays(3)->setHour(11)->setMinute(0),
            'status' => \App\Enums\SlotStatus::Available,
        ]);

        $response = $this->actingAs($user)->post(route('appointments.store', $slot), [
            'name' => 'John Doe',
            'phone' => '+36301234567',
            'service' => 'Oil Change',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_store_appointment_requires_phone(): void
    {
        $user = User::factory()->create();
        $slot = \App\Models\AvailableSlot::create([
            'start_time' => now()->addDays(3)->setHour(10)->setMinute(0),
            'end_time' => now()->addDays(3)->setHour(11)->setMinute(0),
            'status' => \App\Enums\SlotStatus::Available,
        ]);

        $response = $this->actingAs($user)->post(route('appointments.store', $slot), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'service' => 'Oil Change',
        ]);

        $response->assertSessionHasErrors('phone');
    }

    public function test_store_appointment_requires_service(): void
    {
        $user = User::factory()->create();
        $slot = \App\Models\AvailableSlot::create([
            'start_time' => now()->addDays(3)->setHour(10)->setMinute(0),
            'end_time' => now()->addDays(3)->setHour(11)->setMinute(0),
            'status' => \App\Enums\SlotStatus::Available,
        ]);

        $response = $this->actingAs($user)->post(route('appointments.store', $slot), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+36301234567',
        ]);

        $response->assertSessionHasErrors('service');
    }

    public function test_store_appointment_rejects_invalid_email(): void
    {
        $user = User::factory()->create();
        $slot = \App\Models\AvailableSlot::create([
            'start_time' => now()->addDays(3)->setHour(10)->setMinute(0),
            'end_time' => now()->addDays(3)->setHour(11)->setMinute(0),
            'status' => \App\Enums\SlotStatus::Available,
        ]);

        $response = $this->actingAs($user)->post(route('appointments.store', $slot), [
            'name' => 'John Doe',
            'email' => 'not-an-email',
            'phone' => '+36301234567',
            'service' => 'Oil Change',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /*
    |--------------------------------------------------------------------------
    | ContactFormRequest Validation
    |--------------------------------------------------------------------------
    */

    public function test_contact_form_requires_name(): void
    {
        $response = $this->post(route('contact.submit'), [
            'email' => 'jane@example.com',
            'subject' => 'general_inquiry',
            'message' => 'This is a test message for contact form.',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_contact_form_requires_email(): void
    {
        $response = $this->post(route('contact.submit'), [
            'name' => 'Jane Doe',
            'subject' => 'general_inquiry',
            'message' => 'This is a test message for contact form.',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_contact_form_requires_subject(): void
    {
        $response = $this->post(route('contact.submit'), [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'message' => 'This is a test message for contact form.',
        ]);

        $response->assertSessionHasErrors('subject');
    }

    public function test_contact_form_requires_message(): void
    {
        $response = $this->post(route('contact.submit'), [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'subject' => 'general_inquiry',
        ]);

        $response->assertSessionHasErrors('message');
    }

    public function test_contact_form_rejects_invalid_subject(): void
    {
        $response = $this->post(route('contact.submit'), [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'subject' => 'invalid_subject_value',
            'message' => 'This is a valid test message for contact form.',
        ]);

        $response->assertSessionHasErrors('subject');
    }

    public function test_contact_form_accepts_valid_subjects(): void
    {
        \Illuminate\Support\Facades\Mail::fake();

        $validSubjects = ['service_inquiry', 'booking_inquiry', 'general_inquiry', 'feedback', 'other'];

        foreach ($validSubjects as $subject) {
            $response = $this->post(route('contact.submit'), [
                'name' => 'Jane Doe',
                'email' => 'jane@example.com',
                'subject' => $subject,
                'message' => 'This is a valid test message for contact form.',
            ]);

            $response->assertSessionDoesntHaveErrors('subject');
        }
    }

    public function test_contact_form_rejects_short_message(): void
    {
        $response = $this->post(route('contact.submit'), [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'subject' => 'general_inquiry',
            'message' => 'Short',
        ]);

        $response->assertSessionHasErrors('message');
    }

    /*
    |--------------------------------------------------------------------------
    | StoreVehicleRequest Validation
    |--------------------------------------------------------------------------
    */

    public function test_store_vehicle_requires_make(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('vehicles.store'), [
            'model' => 'Corolla',
            'year' => 2020,
        ]);

        $response->assertSessionHasErrors('make');
    }

    public function test_store_vehicle_requires_model(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('vehicles.store'), [
            'make' => 'Toyota',
            'year' => 2020,
        ]);

        $response->assertSessionHasErrors('model');
    }

    public function test_store_vehicle_requires_year(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('vehicles.store'), [
            'make' => 'Toyota',
            'model' => 'Corolla',
        ]);

        $response->assertSessionHasErrors('year');
    }

    public function test_store_vehicle_rejects_invalid_year(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('vehicles.store'), [
            'make' => 'Toyota',
            'model' => 'Corolla',
            'year' => 1800,
        ]);

        $response->assertSessionHasErrors('year');
    }

    /*
    |--------------------------------------------------------------------------
    | StoreScheduleTemplateRequest Validation
    |--------------------------------------------------------------------------
    */

    public function test_store_schedule_template_requires_name(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->post(route('admin.schedule-templates.store'), [
            'day_of_week' => 1,
            'start_time' => '09:00',
            'end_time' => '17:00',
            'slot_duration_minutes' => 60,
            'break_between_minutes' => 15,
            'max_weeks_ahead' => 4,
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_store_schedule_template_requires_day_of_week(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->post(route('admin.schedule-templates.store'), [
            'name' => 'Test',
            'start_time' => '09:00',
            'end_time' => '17:00',
            'slot_duration_minutes' => 60,
            'break_between_minutes' => 15,
            'max_weeks_ahead' => 4,
        ]);

        $response->assertSessionHasErrors('day_of_week');
    }

    public function test_store_schedule_template_rejects_end_time_before_start_time(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->post(route('admin.schedule-templates.store'), [
            'name' => 'Bad Template',
            'day_of_week' => 1,
            'start_time' => '17:00',
            'end_time' => '09:00',
            'slot_duration_minutes' => 60,
            'break_between_minutes' => 15,
            'max_weeks_ahead' => 4,
        ]);

        $response->assertSessionHasErrors('end_time');
    }

    public function test_store_schedule_template_requires_slot_duration(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->post(route('admin.schedule-templates.store'), [
            'name' => 'Test',
            'day_of_week' => 1,
            'start_time' => '09:00',
            'end_time' => '17:00',
            'break_between_minutes' => 15,
            'max_weeks_ahead' => 4,
        ]);

        $response->assertSessionHasErrors('slot_duration_minutes');
    }

    public function test_store_schedule_template_requires_max_weeks_ahead(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->post(route('admin.schedule-templates.store'), [
            'name' => 'Test',
            'day_of_week' => 1,
            'start_time' => '09:00',
            'end_time' => '17:00',
            'slot_duration_minutes' => 60,
            'break_between_minutes' => 15,
        ]);

        $response->assertSessionHasErrors('max_weeks_ahead');
    }
}

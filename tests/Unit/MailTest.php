<?php

namespace Tests\Unit;

use App\Mail\AppointmentApproved;
use App\Mail\AppointmentRejected;
use App\Mail\ContactFormSubmitted;
use App\Models\Appointment;
use App\Models\PendingAppointment;
use App\Models\User;
use App\Enums\AppointmentStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class MailTest extends TestCase
{
    use RefreshDatabase;

    public function test_appointment_approved_mailable_has_correct_content(): void
    {
        $appointment = new Appointment([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+36301234567',
            'vehicle' => '2020 Toyota Corolla',
            'service' => 'Oil Change',
            'appointment_date' => now()->addDays(3),
            'appointment_end' => now()->addDays(3)->addHour(),
            'status' => AppointmentStatus::Confirmed,
        ]);
        $appointment->id = 1;

        $mailable = new AppointmentApproved($appointment);

        $mailable->assertSeeInHtml($appointment->name);
        $mailable->assertSeeInHtml($appointment->service);
    }

    public function test_appointment_approved_mailable_uses_markdown(): void
    {
        $appointment = new Appointment([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '+36301234567',
            'vehicle' => '2021 Honda Civic',
            'service' => 'Brake Inspection',
            'appointment_date' => now()->addDays(5),
            'appointment_end' => now()->addDays(5)->addHour(),
            'status' => AppointmentStatus::Confirmed,
        ]);
        $appointment->id = 2;

        $mailable = new AppointmentApproved($appointment);

        // Verify the content definition uses markdown
        $content = $mailable->content();
        $this->assertEquals('emails.appointment-approved', $content->markdown);
    }

    public function test_appointment_rejected_mailable_has_correct_content(): void
    {
        $pending = new PendingAppointment([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+36301234567',
            'service' => 'Oil Change',
            'status' => 'rejected',
        ]);
        $pending->id = 1;

        $mailable = new AppointmentRejected($pending, 'No availability');

        $mailable->assertSeeInHtml($pending->name);
    }

    public function test_appointment_rejected_mailable_uses_markdown(): void
    {
        $pending = new PendingAppointment([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+36301234567',
            'service' => 'Oil Change',
            'status' => 'rejected',
        ]);
        $pending->id = 1;

        $mailable = new AppointmentRejected($pending, 'Full schedule');

        $content = $mailable->content();
        $this->assertEquals('emails.appointment-rejected', $content->markdown);
    }

    public function test_contact_form_submitted_mailable_has_correct_content(): void
    {
        $contactData = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '+36301234567',
            'subject' => 'service_inquiry',
            'message' => 'I would like to know about your services.',
        ];

        $mailable = new ContactFormSubmitted($contactData);

        $mailable->assertSeeInHtml($contactData['name']);
        $mailable->assertSeeInHtml($contactData['message']);
    }

    public function test_contact_form_submitted_mailable_has_reply_to(): void
    {
        $contactData = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'subject' => 'feedback',
            'message' => 'Great service, thank you!',
        ];

        $mailable = new ContactFormSubmitted($contactData);

        $envelope = $mailable->envelope();
        $this->assertNotEmpty($envelope->replyTo);
    }

    public function test_contact_form_submitted_mailable_uses_markdown(): void
    {
        $contactData = [
            'name' => 'Test',
            'email' => 'test@example.com',
            'subject' => 'other',
            'message' => 'Testing the contact form',
        ];

        $mailable = new ContactFormSubmitted($contactData);

        $content = $mailable->content();
        $this->assertEquals('emails.contact-form-submitted', $content->markdown);
    }

    public function test_mails_implement_should_queue(): void
    {
        $this->assertTrue(
            in_array(\Illuminate\Contracts\Queue\ShouldQueue::class, class_implements(AppointmentApproved::class)),
            'AppointmentApproved should implement ShouldQueue'
        );

        $this->assertTrue(
            in_array(\Illuminate\Contracts\Queue\ShouldQueue::class, class_implements(AppointmentRejected::class)),
            'AppointmentRejected should implement ShouldQueue'
        );

        $this->assertTrue(
            in_array(\Illuminate\Contracts\Queue\ShouldQueue::class, class_implements(ContactFormSubmitted::class)),
            'ContactFormSubmitted should implement ShouldQueue'
        );
    }

    public function test_mails_are_queued_not_sent_synchronously(): void
    {
        Mail::fake();

        $user = User::factory()->create();

        $appointment = new Appointment([
            'name' => 'Test',
            'email' => 'test@example.com',
            'phone' => '+36301234567',
            'vehicle' => 'Test Car',
            'service' => 'Test Service',
            'appointment_date' => now()->addDays(3),
            'appointment_end' => now()->addDays(3)->addHour(),
            'status' => AppointmentStatus::Confirmed,
        ]);
        $appointment->id = 99;

        Mail::to('test@example.com')->queue(new AppointmentApproved($appointment));

        Mail::assertQueued(AppointmentApproved::class);
        Mail::assertNotSent(AppointmentApproved::class);
    }
}

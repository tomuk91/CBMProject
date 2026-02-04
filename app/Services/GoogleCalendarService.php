<?php

namespace App\Services;

use Google\Client;
use Google\Service\Calendar;

class GoogleCalendarService
{
    protected $client;
    protected $calendarService;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setApplicationName('Car Service Booking');
        $this->client->setScopes([Calendar::CALENDAR]);
        
        // Use Service Account authentication
        $credentialsPath = config('services.google.service_account_json');
        
        // Make sure we have an absolute path
        if (!str_starts_with($credentialsPath, '/')) {
            $credentialsPath = base_path($credentialsPath);
        }
        
        if (file_exists($credentialsPath)) {
            $this->client->setAuthConfig($credentialsPath);
        } else {
            throw new \Exception('Google Service Account credentials file not found at: ' . $credentialsPath);
        }

        $this->calendarService = new Calendar($this->client);
    }

    /**
     * Get all available appointment slots from Google Calendar
     * Returns events with "Available" in the title
     */
    public function getAvailableSlots(): array
    {
        $calendarId = config('services.google.calendar_id');
        
        $optParams = [
            'orderBy' => 'startTime',
            'singleEvents' => true,
            'timeMin' => now()->toRfc3339String(),
            'q' => 'Available', // Search for events with "Available" in title
        ];

        $events = $this->calendarService->events->listEvents($calendarId, $optParams);
        
        $availableSlots = [];
        foreach ($events->getItems() as $event) {
            // Only include events that have "Available" as the exact title or starts with "Available"
            if (stripos($event->getSummary(), 'Available') !== false) {
                $availableSlots[] = [
                    'id' => $event->getId(),
                    'title' => $event->getSummary(),
                    'start' => $event->getStart()->getDateTime() ?? $event->getStart()->getDate(),
                    'end' => $event->getEnd()->getDateTime() ?? $event->getEnd()->getDate(),
                    'description' => $event->getDescription(),
                ];
            }
        }

        return $availableSlots;
    }

    /**
     * Book an appointment by updating the calendar event
     */
    public function bookAppointment(string $eventId, array $clientData): bool
    {
        try {
            $calendarId = config('services.google.calendar_id');
            $event = $this->calendarService->events->get($calendarId, $eventId);

            // Update event with client information
            $event->setSummary('Booked - ' . $clientData['name']);
            $event->setDescription(
                "Client: {$clientData['name']}\n" .
                "Email: {$clientData['email']}\n" .
                "Phone: {$clientData['phone']}\n" .
                "Vehicle: {$clientData['vehicle']}\n" .
                "Service: {$clientData['service']}\n" .
                "Notes: " . ($clientData['notes'] ?? 'N/A')
            );

            // Note: Service accounts cannot add attendees without Domain-Wide Delegation
            // The client information is stored in the description instead

            $this->calendarService->events->update($calendarId, $eventId, $event);

            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to book appointment: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get a specific event by ID
     */
    public function getEvent(string $eventId): ?array
    {
        try {
            $calendarId = config('services.google.calendar_id');
            $event = $this->calendarService->events->get($calendarId, $eventId);

            return [
                'id' => $event->getId(),
                'title' => $event->getSummary(),
                'start' => $event->getStart()->getDateTime() ?? $event->getStart()->getDate(),
                'end' => $event->getEnd()->getDateTime() ?? $event->getEnd()->getDate(),
                'description' => $event->getDescription(),
            ];
        } catch (\Exception $e) {
            \Log::error('Failed to get event: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get user's booked appointments from Google Calendar
     * Returns events that contain the user's email in the description
     */
    public function getUserAppointments(string $userEmail): array
    {
        try {
            $calendarId = config('services.google.calendar_id');
            
            $optParams = [
                'orderBy' => 'startTime',
                'singleEvents' => true,
                'timeMin' => now()->toRfc3339String(),
                'q' => 'Booked', // Search for booked events
            ];

            $events = $this->calendarService->events->listEvents($calendarId, $optParams);
            
            $userAppointments = [];
            foreach ($events->getItems() as $event) {
                $description = $event->getDescription() ?? '';
                
                // Check if this event belongs to the user by email
                if (stripos($description, $userEmail) !== false) {
                    $userAppointments[] = [
                        'id' => $event->getId(),
                        'title' => $event->getSummary(),
                        'start' => $event->getStart()->getDateTime() ?? $event->getStart()->getDate(),
                        'end' => $event->getEnd()->getDateTime() ?? $event->getEnd()->getDate(),
                        'description' => $description,
                    ];
                }
            }

            return $userAppointments;
        } catch (\Exception $e) {
            \Log::error('Failed to get user appointments: ' . $e->getMessage());
            return [];
        }
    }
}

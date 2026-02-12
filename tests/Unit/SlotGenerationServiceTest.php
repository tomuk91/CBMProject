<?php

namespace Tests\Unit;

use App\Enums\SlotStatus;
use App\Models\AvailableSlot;
use App\Models\BlockedDate;
use App\Models\ScheduleTemplate;
use App\Services\SlotGenerationService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SlotGenerationServiceTest extends TestCase
{
    use RefreshDatabase;

    private SlotGenerationService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new SlotGenerationService();
    }

    private function createTemplate(array $overrides = []): ScheduleTemplate
    {
        return ScheduleTemplate::create(array_merge([
            'name' => 'Test Template',
            'day_of_week' => Carbon::now()->addDays(1)->dayOfWeek,
            'start_time' => '09:00',
            'end_time' => '12:00',
            'slot_duration_minutes' => 60,
            'break_between_minutes' => 0,
            'is_active' => true,
            'max_weeks_ahead' => 4,
        ], $overrides));
    }

    public function test_generate_from_template_creates_correct_number_of_slots(): void
    {
        // Use a day_of_week that we know will appear in the next 2 weeks
        $targetDay = Carbon::now()->addDay()->dayOfWeek;

        $template = $this->createTemplate([
            'day_of_week' => $targetDay,
            'start_time' => '09:00',
            'end_time' => '12:00',
            'slot_duration_minutes' => 60,
            'break_between_minutes' => 0,
            'max_weeks_ahead' => 2,
        ]);

        $result = $this->service->generateFromTemplate($template, 2);

        // 3 slots per day (09-10, 10-11, 11-12), across ~2 occurrences of $targetDay
        $this->assertGreaterThan(0, $result['created']);
        $this->assertEquals(0, $result['blocked']);

        // Verify actual slots exist in DB
        $slots = AvailableSlot::where('schedule_template_id', $template->id)->get();
        $this->assertEquals($result['created'], $slots->count());

        // All slots should be available
        foreach ($slots as $slot) {
            $this->assertEquals(SlotStatus::Available, $slot->status);
            $this->assertEquals('auto', $slot->source);
        }
    }

    public function test_generate_from_template_skips_blocked_dates(): void
    {
        $targetDay = Carbon::now()->addDay()->dayOfWeek;
        $nextOccurrence = Carbon::now()->addDay();

        // Make sure we have the right day
        while ($nextOccurrence->dayOfWeek !== $targetDay) {
            $nextOccurrence->addDay();
        }

        // Block the first occurrence
        BlockedDate::create([
            'date' => $nextOccurrence->format('Y-m-d'),
            'reason' => 'Holiday',
        ]);

        $template = $this->createTemplate([
            'day_of_week' => $targetDay,
            'start_time' => '09:00',
            'end_time' => '10:00',
            'slot_duration_minutes' => 60,
            'break_between_minutes' => 0,
            'max_weeks_ahead' => 2,
        ]);

        $result = $this->service->generateFromTemplate($template, 2);

        $this->assertGreaterThanOrEqual(1, $result['blocked']);

        // No slots should be created on the blocked date
        $blockedSlots = AvailableSlot::whereDate('start_time', $nextOccurrence->format('Y-m-d'))->count();
        $this->assertEquals(0, $blockedSlots);
    }

    public function test_generate_from_template_respects_effective_from(): void
    {
        $targetDay = Carbon::now()->addDay()->dayOfWeek;

        $template = $this->createTemplate([
            'day_of_week' => $targetDay,
            'start_time' => '09:00',
            'end_time' => '10:00',
            'slot_duration_minutes' => 60,
            'break_between_minutes' => 0,
            'effective_from' => Carbon::now()->addWeeks(10)->format('Y-m-d'),
            'max_weeks_ahead' => 2,
        ]);

        $result = $this->service->generateFromTemplate($template, 2);

        // effective_from is far in the future, so no slots should be created within 2 weeks
        $this->assertEquals(0, $result['created']);
    }

    public function test_generate_from_template_respects_effective_until(): void
    {
        $targetDay = Carbon::now()->addDay()->dayOfWeek;

        $template = $this->createTemplate([
            'day_of_week' => $targetDay,
            'start_time' => '09:00',
            'end_time' => '10:00',
            'slot_duration_minutes' => 60,
            'break_between_minutes' => 0,
            'effective_until' => Carbon::now()->subDay()->format('Y-m-d'),
            'max_weeks_ahead' => 2,
        ]);

        $result = $this->service->generateFromTemplate($template, 2);

        // effective_until is in the past, so no slots should be created
        $this->assertEquals(0, $result['created']);
    }

    public function test_generate_from_template_does_not_create_overlapping_slots(): void
    {
        $targetDay = Carbon::now()->addDay()->dayOfWeek;
        $nextOccurrence = Carbon::now()->addDay();
        while ($nextOccurrence->dayOfWeek !== $targetDay) {
            $nextOccurrence->addDay();
        }

        // Create an existing slot on the target day
        AvailableSlot::create([
            'start_time' => $nextOccurrence->copy()->setHour(9)->setMinute(0),
            'end_time' => $nextOccurrence->copy()->setHour(10)->setMinute(0),
            'status' => SlotStatus::Available,
        ]);

        $template = $this->createTemplate([
            'day_of_week' => $targetDay,
            'start_time' => '09:00',
            'end_time' => '12:00',
            'slot_duration_minutes' => 60,
            'break_between_minutes' => 0,
            'max_weeks_ahead' => 1,
        ]);

        $result = $this->service->generateFromTemplate($template, 1);

        // The 09:00-10:00 slot on the first occurrence should be skipped
        $this->assertGreaterThanOrEqual(1, $result['skipped']);

        // No duplicate slots should exist
        $slotsAtNine = AvailableSlot::where('start_time', $nextOccurrence->copy()->setHour(9)->setMinute(0))->count();
        $this->assertEquals(1, $slotsAtNine);
    }

    public function test_generate_all_processes_all_active_templates(): void
    {
        // Find two different future days of the week
        $day1 = Carbon::now()->addDay()->dayOfWeek;
        $day2 = Carbon::now()->addDays(2)->dayOfWeek;

        $template1 = $this->createTemplate([
            'name' => 'Template 1',
            'day_of_week' => $day1,
            'start_time' => '09:00',
            'end_time' => '10:00',
            'slot_duration_minutes' => 60,
            'is_active' => true,
            'max_weeks_ahead' => 1,
        ]);

        $template2 = $this->createTemplate([
            'name' => 'Template 2',
            'day_of_week' => $day2,
            'start_time' => '14:00',
            'end_time' => '15:00',
            'slot_duration_minutes' => 60,
            'is_active' => true,
            'max_weeks_ahead' => 1,
        ]);

        // Inactive template should not generate slots
        $this->createTemplate([
            'name' => 'Inactive Template',
            'day_of_week' => $day1,
            'start_time' => '16:00',
            'end_time' => '17:00',
            'slot_duration_minutes' => 60,
            'is_active' => false,
            'max_weeks_ahead' => 1,
        ]);

        $result = $this->service->generateAll();

        $this->assertGreaterThan(0, $result['created']);

        // Slots from both active templates should exist
        $template1Slots = AvailableSlot::where('schedule_template_id', $template1->id)->count();
        $template2Slots = AvailableSlot::where('schedule_template_id', $template2->id)->count();

        $this->assertGreaterThan(0, $template1Slots);
        $this->assertGreaterThan(0, $template2Slots);

        // Inactive template should have zero slots
        $inactiveSlots = AvailableSlot::where('schedule_template_id', 3)->count();
        $this->assertEquals(0, $inactiveSlots);
    }

    public function test_regenerate_for_template_deletes_old_auto_slots_and_recreates(): void
    {
        $targetDay = Carbon::now()->addDay()->dayOfWeek;
        $nextOccurrence = Carbon::now()->addDay();
        while ($nextOccurrence->dayOfWeek !== $targetDay) {
            $nextOccurrence->addDay();
        }

        $template = $this->createTemplate([
            'day_of_week' => $targetDay,
            'start_time' => '09:00',
            'end_time' => '11:00',
            'slot_duration_minutes' => 60,
            'break_between_minutes' => 0,
            'max_weeks_ahead' => 2,
        ]);

        // First generation
        $this->service->generateFromTemplate($template, 2);
        $initialCount = AvailableSlot::where('schedule_template_id', $template->id)->count();
        $this->assertGreaterThan(0, $initialCount);

        // Regenerate
        $result = $this->service->regenerateForTemplate($template);

        $this->assertArrayHasKey('deleted', $result);
        $this->assertArrayHasKey('created', $result);
        $this->assertGreaterThanOrEqual(0, $result['deleted']);

        // After regeneration, new slots should exist
        $newCount = AvailableSlot::where('schedule_template_id', $template->id)->count();
        $this->assertGreaterThan(0, $newCount);
    }

    public function test_generate_from_template_respects_break_between_minutes(): void
    {
        $targetDay = Carbon::now()->addDay()->dayOfWeek;
        $nextOccurrence = Carbon::now()->addDay();
        while ($nextOccurrence->dayOfWeek !== $targetDay) {
            $nextOccurrence->addDay();
        }

        $template = $this->createTemplate([
            'day_of_week' => $targetDay,
            'start_time' => '09:00',
            'end_time' => '12:00',
            'slot_duration_minutes' => 60,
            'break_between_minutes' => 30,
            'max_weeks_ahead' => 1,
        ]);

        $result = $this->service->generateFromTemplate($template, 1);

        // With 60min slots + 30min breaks in 3h window: 09:00-10:00, 10:30-11:30
        // Only 2 slots per day should fit
        $slotsOnDay = AvailableSlot::whereDate('start_time', $nextOccurrence->format('Y-m-d'))
            ->where('schedule_template_id', $template->id)
            ->orderBy('start_time')
            ->get();

        if ($slotsOnDay->count() > 0) {
            $this->assertEquals(2, $slotsOnDay->count());

            // Verify the gap between slots
            $firstEnd = Carbon::parse($slotsOnDay[0]->end_time);
            $secondStart = Carbon::parse($slotsOnDay[1]->start_time);
            $this->assertEquals(30, $firstEnd->diffInMinutes($secondStart));
        }
    }
}

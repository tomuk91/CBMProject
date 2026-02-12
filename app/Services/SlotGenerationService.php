<?php

namespace App\Services;

use App\Enums\SlotStatus;
use App\Models\ScheduleTemplate;
use App\Models\AvailableSlot;
use App\Models\BlockedDate;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SlotGenerationService
{
    /**
     * Generate slots from ALL active templates.
     * Called by the scheduled artisan command.
     *
     * @param int|null $weeksAhead Override max_weeks_ahead for all templates
     * @return array ['created' => int, 'skipped' => int, 'blocked' => int]
     */
    public function generateAll(?int $weeksAhead = null): array
    {
        $templates = ScheduleTemplate::active()->get();
        $totals = ['created' => 0, 'skipped' => 0, 'blocked' => 0];

        foreach ($templates as $template) {
            try {
                $result = DB::transaction(function () use ($template, $weeksAhead) {
                    return $this->generateFromTemplate($template, $weeksAhead ?? $template->max_weeks_ahead);
                });
                $totals['created'] += $result['created'];
                $totals['skipped'] += $result['skipped'];
                $totals['blocked'] += $result['blocked'];
            } catch (\Throwable $e) {
                Log::error('Slot generation failed for template #' . $template->id . ': ' . $e->getMessage(), [
                    'template_id' => $template->id,
                    'exception' => $e,
                ]);
            }
        }

        return $totals;
    }

    /**
     * Generate slots from a single template for N weeks ahead.
     *
     * Logic:
     * - Starting from today, iterate day by day up to $weeksAhead weeks
     * - For each day that matches the template's day_of_week:
     *   - Skip if BlockedDate::isBlocked($date) is true
     *   - Skip if template->isEffectiveOn($date) is false
     *   - Calculate slots: start at template->start_time, create slots of
     *     slot_duration_minutes with break_between_minutes gaps until template->end_time
     *   - For each candidate slot, check for overlap with existing AvailableSlot records
     *     (start_time < slotEnd AND end_time > slotStart)
     *   - If no overlap, create with source='auto' and schedule_template_id set
     *   - Track created/skipped/blocked counts
     *
     * @return array ['created' => int, 'skipped' => int, 'blocked' => int]
     */
    public function generateFromTemplate(ScheduleTemplate $template, int $weeksAhead = 4): array
    {
        $created = 0;
        $skipped = 0;
        $blocked = 0;

        $startDate = now()->startOfDay();
        $endDate = now()->addWeeks($weeksAhead)->endOfDay();

        $current = $startDate->copy();

        while ($current->lte($endDate)) {
            // Only process days matching the template's day_of_week
            if ($current->dayOfWeek === $template->day_of_week) {
                // Check if the date is blocked
                if (BlockedDate::isBlocked($current)) {
                    $blocked++;
                    $current->addDay();
                    continue;
                }

                // Check if the template is effective on this date
                if (!$template->isEffectiveOn($current)) {
                    $current->addDay();
                    continue;
                }

                // Generate slots for this day
                $result = $this->generateSlotsForDay($template, $current);
                $created += $result['created'];
                $skipped += $result['skipped'];
            }

            $current->addDay();
        }

        return ['created' => $created, 'skipped' => $skipped, 'blocked' => $blocked];
    }

    /**
     * Preview what slots WOULD be generated from a template without creating them.
     * Returns a Collection of arrays with 'start_time' and 'end_time' keys.
     */
    public function previewSlots(ScheduleTemplate $template, int $weeksAhead = 4): Collection
    {
        $slots = collect();

        $startDate = now()->startOfDay();
        $endDate = now()->addWeeks($weeksAhead)->endOfDay();

        // Pre-load all existing slots in the date range to avoid N+1
        $existingSlots = AvailableSlot::where('start_time', '>=', $startDate)
            ->where('end_time', '<=', $endDate->copy()->addHour())
            ->get(['start_time', 'end_time'])
            ->map(fn ($s) => ['start' => $s->start_time, 'end' => $s->end_time])
            ->toArray();

        $current = $startDate->copy();

        while ($current->lte($endDate)) {
            if ($current->dayOfWeek === $template->day_of_week) {
                if (BlockedDate::isBlocked($current)) {
                    $current->addDay();
                    continue;
                }

                if (!$template->isEffectiveOn($current)) {
                    $current->addDay();
                    continue;
                }

                // Build candidate slots for this day
                $dayStart = $current->copy()->setTimeFromTimeString($template->start_time);
                $dayEnd = $current->copy()->setTimeFromTimeString($template->end_time);

                $slotStart = $dayStart->copy();

                while ($slotStart->copy()->addMinutes($template->slot_duration_minutes)->lte($dayEnd)) {
                    $slotEnd = $slotStart->copy()->addMinutes($template->slot_duration_minutes);

                    // Check for overlap against in-memory collection
                    $overlapping = false;
                    foreach ($existingSlots as $existing) {
                        if ($existing['start'] < $slotEnd && $existing['end'] > $slotStart) {
                            $overlapping = true;
                            break;
                        }
                    }

                    if (!$overlapping) {
                        $slots->push([
                            'start_time' => $slotStart->copy(),
                            'end_time' => $slotEnd->copy(),
                        ]);
                    }

                    // Move to next slot: duration + break
                    $slotStart->addMinutes($template->slot_duration_minutes + $template->break_between_minutes);
                }
            }

            $current->addDay();
        }

        return $slots;
    }

    /**
     * Regenerate auto-generated slots from a specific date forward.
     * Used when a template is edited — deletes future auto-generated unfilled slots
     * for that template, then regenerates.
     *
     * @return array ['deleted' => int, 'created' => int, 'skipped' => int, 'blocked' => int]
     */
    public function regenerateForTemplate(ScheduleTemplate $template, ?Carbon $fromDate = null): array
    {
        $fromDate = $fromDate ?? now();

        return DB::transaction(function () use ($template, $fromDate) {
            // Delete future auto-generated slots that are still 'available' for this template
            $deleted = AvailableSlot::where('schedule_template_id', $template->id)
                ->where('source', 'auto')
                ->where('status', 'available')
                ->where('start_time', '>=', $fromDate)
                ->delete();

            // Regenerate
            $result = $this->generateFromTemplate($template);
            $result['deleted'] = $deleted;

            return $result;
        });
    }

    /**
     * Generate individual slots for a specific day based on a template.
     *
     * @return array ['created' => int, 'skipped' => int]
     */
    protected function generateSlotsForDay(ScheduleTemplate $template, Carbon $date): array
    {
        $created = 0;
        $skipped = 0;

        $dayStart = $date->copy()->setTimeFromTimeString($template->start_time);
        $dayEnd = $date->copy()->setTimeFromTimeString($template->end_time);

        // Pre-load all existing slots for this day to avoid N+1 queries
        $existingSlots = AvailableSlot::where('start_time', '>=', $dayStart)
            ->where('end_time', '<=', $dayEnd->copy()->addHour()) // small buffer
            ->get(['start_time', 'end_time'])
            ->map(fn ($s) => ['start' => $s->start_time, 'end' => $s->end_time])
            ->toArray();

        $slotStart = $dayStart->copy();

        while ($slotStart->copy()->addMinutes($template->slot_duration_minutes)->lte($dayEnd)) {
            $slotEnd = $slotStart->copy()->addMinutes($template->slot_duration_minutes);

            // Check for overlap against in-memory collection instead of DB query
            $overlapping = false;
            foreach ($existingSlots as $existing) {
                if ($existing['start'] < $slotEnd && $existing['end'] > $slotStart) {
                    $overlapping = true;
                    break;
                }
            }

            if ($overlapping) {
                $skipped++;
            } else {
                $newSlot = AvailableSlot::create([
                    'start_time' => $slotStart,
                    'end_time' => $slotEnd,
                    'status' => SlotStatus::Available,
                    'schedule_template_id' => $template->id,
                    'source' => 'auto',
                ]);
                $created++;

                // Add to in-memory collection so subsequent slots on same day see it
                $existingSlots[] = ['start' => $newSlot->start_time, 'end' => $newSlot->end_time];
            }

            // Move to next slot: duration + break
            $slotStart->addMinutes($template->slot_duration_minutes + $template->break_between_minutes);
        }

        return ['created' => $created, 'skipped' => $skipped];
    }
}

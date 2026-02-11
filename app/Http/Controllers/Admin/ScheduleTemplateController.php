<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\AvailableSlot;
use App\Models\ScheduleTemplate;
use App\Services\SlotGenerationService;
use Illuminate\Http\Request;

class ScheduleTemplateController extends Controller
{
    protected SlotGenerationService $slotService;

    public function __construct(SlotGenerationService $slotService)
    {
        $this->slotService = $slotService;
    }

    /**
     * List all schedule templates ordered by day_of_week then start_time.
     */
    public function index()
    {
        $templates = ScheduleTemplate::orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();

        return view('admin.schedule-templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new schedule template.
     */
    public function create()
    {
        return view('admin.schedule-templates.create');
    }

    /**
     * Store a newly created schedule template.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'day_of_week' => 'required|integer|between:0,6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'slot_duration_minutes' => 'required|integer|min:15|max:480',
            'break_between_minutes' => 'required|integer|min:0|max:240',
            'is_active' => 'boolean',
            'effective_from' => 'nullable|date',
            'effective_until' => 'nullable|date|after_or_equal:effective_from',
            'max_weeks_ahead' => 'required|integer|min:1|max:12',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $template = ScheduleTemplate::create($validated);

        if ($template->is_active) {
            $this->slotService->generateFromTemplate($template);
        }

        ActivityLog::log(
            'schedule_template_created',
            "Schedule template '{$template->name}' created for {$template->day_name}",
            $template
        );

        return redirect()->route('admin.schedule-templates.index')
            ->with('success', 'Schedule template created successfully.');
    }

    /**
     * Show the form for editing the specified schedule template.
     */
    public function edit(ScheduleTemplate $template)
    {
        return view('admin.schedule-templates.edit', compact('template'));
    }

    /**
     * Update the specified schedule template.
     */
    public function update(Request $request, ScheduleTemplate $template)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'day_of_week' => 'required|integer|between:0,6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'slot_duration_minutes' => 'required|integer|min:15|max:480',
            'break_between_minutes' => 'required|integer|min:0|max:240',
            'is_active' => 'boolean',
            'effective_from' => 'nullable|date',
            'effective_until' => 'nullable|date|after_or_equal:effective_from',
            'max_weeks_ahead' => 'required|integer|min:1|max:12',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $oldValues = $template->toArray();
        $template->update($validated);

        if ($template->is_active) {
            $this->slotService->regenerateForTemplate($template);
        }

        ActivityLog::log(
            'schedule_template_updated',
            "Schedule template '{$template->name}' updated",
            $template,
            ['old' => $oldValues, 'new' => $template->toArray()]
        );

        return redirect()->route('admin.schedule-templates.index')
            ->with('success', 'Schedule template updated successfully.');
    }

    /**
     * Delete the specified schedule template and its future auto-generated slots.
     */
    public function destroy(ScheduleTemplate $template)
    {
        $templateName = $template->name;

        // Delete future auto-generated available slots for this template
        AvailableSlot::where('schedule_template_id', $template->id)
            ->where('source', 'auto')
            ->where('status', 'available')
            ->where('start_time', '>=', now())
            ->delete();

        $template->delete();

        ActivityLog::log(
            'schedule_template_deleted',
            "Schedule template '{$templateName}' deleted",
        );

        return redirect()->route('admin.schedule-templates.index')
            ->with('success', 'Schedule template deleted successfully.');
    }

    /**
     * Toggle the active status of a schedule template.
     */
    public function toggleActive(ScheduleTemplate $template)
    {
        $template->update(['is_active' => !$template->is_active]);

        if ($template->is_active) {
            $this->slotService->generateFromTemplate($template);
        }

        $status = $template->is_active ? 'activated' : 'deactivated';

        ActivityLog::log(
            'schedule_template_toggled',
            "Schedule template '{$template->name}' {$status}",
            $template,
            ['is_active' => $template->is_active]
        );

        return redirect()->route('admin.schedule-templates.index')
            ->with('success', "Schedule template {$status} successfully.");
    }

    /**
     * Duplicate an existing schedule template.
     */
    public function duplicate(ScheduleTemplate $template)
    {
        $newTemplate = $template->replicate();
        $newTemplate->name = $template->name . ' ' . __('messages.schedule_template_duplicate_suffix');
        $newTemplate->is_active = false;
        $newTemplate->save();

        ActivityLog::log(
            'schedule_template_duplicated',
            "Schedule template '{$template->name}' duplicated as '{$newTemplate->name}'",
            $newTemplate
        );

        return redirect()->route('admin.schedule-templates.index')
            ->with('success', __('messages.schedule_template_duplicated'));
    }

    /**
     * Bulk activate selected templates.
     */
    public function bulkActivate(Request $request)
    {
        $ids = $request->input('template_ids', []);
        if (empty($ids)) {
            return redirect()->route('admin.schedule-templates.index')
                ->with('error', 'No templates selected.');
        }

        $templates = ScheduleTemplate::whereIn('id', $ids)->get();
        $count = 0;

        foreach ($templates as $template) {
            if (!$template->is_active) {
                $template->update(['is_active' => true]);
                $this->slotService->generateFromTemplate($template);
                $count++;
            }
        }

        ActivityLog::log(
            'schedule_templates_bulk_activated',
            "{$count} schedule templates activated via bulk action"
        );

        return redirect()->route('admin.schedule-templates.index')
            ->with('success', __('messages.schedule_template_bulk_activated', ['count' => $count]));
    }

    /**
     * Bulk deactivate selected templates.
     */
    public function bulkDeactivate(Request $request)
    {
        $ids = $request->input('template_ids', []);
        if (empty($ids)) {
            return redirect()->route('admin.schedule-templates.index')
                ->with('error', 'No templates selected.');
        }

        $count = ScheduleTemplate::whereIn('id', $ids)
            ->where('is_active', true)
            ->update(['is_active' => false]);

        ActivityLog::log(
            'schedule_templates_bulk_deactivated',
            "{$count} schedule templates deactivated via bulk action"
        );

        return redirect()->route('admin.schedule-templates.index')
            ->with('success', __('messages.schedule_template_bulk_deactivated', ['count' => $count]));
    }

    /**
     * Bulk delete selected templates and their future slots.
     */
    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('template_ids', []);
        if (empty($ids)) {
            return redirect()->route('admin.schedule-templates.index')
                ->with('error', 'No templates selected.');
        }

        // Delete future auto-generated available slots for these templates
        AvailableSlot::whereIn('schedule_template_id', $ids)
            ->where('source', 'auto')
            ->where('status', 'available')
            ->where('start_time', '>=', now())
            ->delete();

        $count = ScheduleTemplate::whereIn('id', $ids)->delete();

        ActivityLog::log(
            'schedule_templates_bulk_deleted',
            "{$count} schedule templates deleted via bulk action"
        );

        return redirect()->route('admin.schedule-templates.index')
            ->with('success', __('messages.schedule_template_bulk_deleted', ['count' => $count]));
    }

    /**
     * Preview slots that would be generated from the given template data (AJAX).
     */
    public function preview(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'day_of_week' => 'required|integer|between:0,6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'slot_duration_minutes' => 'required|integer|min:15|max:480',
            'break_between_minutes' => 'required|integer|min:0|max:240',
            'effective_from' => 'nullable|date',
            'effective_until' => 'nullable|date|after_or_equal:effective_from',
            'max_weeks_ahead' => 'required|integer|min:1|max:12',
        ]);

        // Create a temporary (non-persisted) template for preview
        $template = new ScheduleTemplate($validated);
        $template->is_active = true;

        $slots = $this->slotService->previewSlots($template, $validated['max_weeks_ahead']);

        $formatted = $slots->map(function ($slot) {
            return [
                'start_time' => $slot['start_time']->format('Y-m-d H:i'),
                'end_time' => $slot['end_time']->format('Y-m-d H:i'),
                'day' => $slot['start_time']->format('l'),
                'date' => $slot['start_time']->format('Y-m-d'),
                'time_range' => $slot['start_time']->format('H:i') . ' - ' . $slot['end_time']->format('H:i'),
            ];
        });

        return response()->json([
            'slots' => $formatted,
            'total' => $formatted->count(),
        ]);
    }
}

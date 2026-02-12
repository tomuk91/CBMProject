<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceType;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ServiceTypeController extends Controller
{
    /**
     * Display a listing of service types.
     */
    public function index()
    {
        $serviceTypes = ServiceType::ordered()->get();

        return view('admin.service-types.index', compact('serviceTypes'));
    }

    /**
     * Show the form for creating a new service type.
     */
    public function create()
    {
        return view('admin.service-types.create');
    }

    /**
     * Store a newly created service type.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:service_types,name',
            'description' => 'nullable|string|max:1000',
            'icon' => 'nullable|string|max:10',
            'estimated_duration' => 'nullable|string|max:50',
            'price_from' => 'nullable|numeric|min:0',
            'price_to' => 'nullable|numeric|min:0|gte:price_from',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $serviceType = ServiceType::create($validated);

        ActivityLog::log(
            'created',
            "Created service type: {$serviceType->name}",
            $serviceType
        );

        return redirect()->route('admin.service-types.index')
            ->with('success', __('messages.service_type_created'));
    }

    /**
     * Show the form for editing a service type.
     */
    public function edit(ServiceType $serviceType)
    {
        return view('admin.service-types.edit', compact('serviceType'));
    }

    /**
     * Update the specified service type.
     */
    public function update(Request $request, ServiceType $serviceType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:service_types,name,' . $serviceType->id,
            'description' => 'nullable|string|max:1000',
            'icon' => 'nullable|string|max:10',
            'estimated_duration' => 'nullable|string|max:50',
            'price_from' => 'nullable|numeric|min:0',
            'price_to' => 'nullable|numeric|min:0|gte:price_from',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $serviceType->update($validated);

        ActivityLog::log(
            'updated',
            "Updated service type: {$serviceType->name}",
            $serviceType
        );

        return redirect()->route('admin.service-types.index')
            ->with('success', __('messages.service_type_updated'));
    }

    /**
     * Remove the specified service type.
     */
    public function destroy(ServiceType $serviceType)
    {
        $name = $serviceType->name;
        $serviceType->delete();

        ActivityLog::log(
            'deleted',
            "Deleted service type: {$name}"
        );

        return redirect()->route('admin.service-types.index')
            ->with('success', __('messages.service_type_deleted'));
    }

    /**
     * Toggle active status of a service type.
     */
    public function toggleActive(ServiceType $serviceType)
    {
        $serviceType->update(['is_active' => !$serviceType->is_active]);

        $status = $serviceType->is_active ? 'activated' : 'deactivated';

        ActivityLog::log(
            'updated',
            "Service type {$status}: {$serviceType->name}",
            $serviceType
        );

        return response()->json([
            'success' => true,
            'is_active' => $serviceType->is_active,
            'message' => "Service type {$status}.",
        ]);
    }
}

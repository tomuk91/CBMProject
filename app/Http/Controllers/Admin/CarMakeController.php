<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\CarMake;
use App\Models\CarModel;
use Illuminate\Http\Request;

class CarMakeController extends Controller
{
    public function index()
    {
        $carMakes = CarMake::withCount('carModels')->orderBy('name')->get();

        return view('admin.car-makes.index', compact('carMakes'));
    }

    public function create()
    {
        return view('admin.car-makes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:100|unique:car_makes,name',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $carMake = CarMake::create($validated);

        ActivityLog::log('created', "Created car make: {$carMake->name}", $carMake);

        return redirect()->route('admin.car-makes.index')
            ->with('success', __('messages.car_make_created'));
    }

    public function edit(CarMake $carMake)
    {
        $carMake->load(['carModels' => fn ($q) => $q->orderBy('name')]);

        return view('admin.car-makes.edit', compact('carMake'));
    }

    public function update(Request $request, CarMake $carMake)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:100|unique:car_makes,name,' . $carMake->id,
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $carMake->update($validated);

        ActivityLog::log('updated', "Updated car make: {$carMake->name}", $carMake);

        return redirect()->route('admin.car-makes.index')
            ->with('success', __('messages.car_make_updated'));
    }

    public function destroy(CarMake $carMake)
    {
        $name = $carMake->name;
        $carMake->delete();

        ActivityLog::log('deleted', "Deleted car make: {$name}");

        return redirect()->route('admin.car-makes.index')
            ->with('success', __('messages.car_make_deleted'));
    }

    // ── Model management (nested under a make) ─────────────────────────────

    public function storeModel(Request $request, CarMake $carMake)
    {
        $validated = $request->validateWithBag('model', [
            'name'      => 'required|string|max:100|unique:car_models,name,NULL,id,car_make_id,' . $carMake->id,
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $model = $carMake->carModels()->create($validated);

        ActivityLog::log('created', "Added model {$model->name} to {$carMake->name}", $model);

        return redirect()->route('admin.car-makes.edit', $carMake)
            ->with('success', __('messages.car_model_created'));
    }

    public function updateModel(Request $request, CarMake $carMake, CarModel $carModel)
    {
        abort_if($carModel->car_make_id !== $carMake->id, 404);

        $validated = $request->validate([
            'name'      => 'required|string|max:100|unique:car_models,name,' . $carModel->id . ',id,car_make_id,' . $carMake->id,
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $carModel->update($validated);

        ActivityLog::log('updated', "Updated model {$carModel->name} under {$carMake->name}", $carModel);

        return redirect()->route('admin.car-makes.edit', $carMake)
            ->with('success', __('messages.car_model_updated'));
    }

    public function destroyModel(CarMake $carMake, CarModel $carModel)
    {
        abort_if($carModel->car_make_id !== $carMake->id, 404);

        $name = $carModel->name;
        $carModel->delete();

        ActivityLog::log('deleted', "Deleted model {$name} from {$carMake->name}");

        return redirect()->route('admin.car-makes.edit', $carMake)
            ->with('success', __('messages.car_model_deleted'));
    }
}

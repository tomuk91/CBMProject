<?php

namespace App\Http\Requests;

use App\Models\CarMake;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVehicleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'make'         => ['required', 'string', 'max:100', Rule::exists('car_makes', 'name')->where('is_active', true)],
            'model'        => ['required', 'string', 'max:100', $this->modelExistsRule()],
            'year'         => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'color'        => 'nullable|string|max:255',
            'plate'        => 'nullable|string|max:255',
            'fuel_type'    => 'nullable|string|max:255',
            'transmission' => 'nullable|string|max:255',
            'engine_size'  => 'nullable|string|max:255',
            'notes'        => 'nullable|string',
            'is_primary'   => 'sometimes|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'make.required' => __('messages.validation.vehicle_make_required'),
            'make.exists'   => __('messages.validation.vehicle_make_invalid'),
            'model.required' => __('messages.validation.vehicle_model_required'),
            'model.exists'   => __('messages.validation.vehicle_model_invalid'),
            'year.required' => __('messages.validation.vehicle_year_required'),
            'year.max'      => __('messages.validation.vehicle_year_format'),
            'plate.max'     => __('messages.validation.vehicle_plate_max', ['max' => 255]),
        ];
    }

    private function modelExistsRule(): \Illuminate\Validation\Rules\Exists
    {
        $make = CarMake::where('name', $this->input('make'))->where('is_active', true)->first();

        return Rule::exists('car_models', 'name')
            ->where('is_active', true)
            ->when($make, fn ($rule) => $rule->where('car_make_id', $make->id));
    }
}

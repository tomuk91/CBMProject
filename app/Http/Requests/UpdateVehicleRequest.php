<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVehicleRequest extends FormRequest
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
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'color' => 'nullable|string|max:255',
            'plate' => 'nullable|string|max:255',
            'fuel_type' => 'nullable|string|max:255',
            'transmission' => 'nullable|string|max:255',
            'engine_size' => 'nullable|string|max:255',
            'mileage' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'is_primary' => 'sometimes|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            'make.max' => __('messages.validation.max_length', ['max' => 255]),
            'model.required' => __('messages.validation.vehicle_model_required'),
            'model.max' => __('messages.validation.max_length', ['max' => 255]),
            'year.required' => __('messages.validation.vehicle_year_required'),
            'year.max' => __('messages.validation.vehicle_year_format'),
            'plate.max' => __('messages.validation.vehicle_plate_max', ['max' => 255]),
            'image.image' => __('messages.validation.image_type'),
            'image.mimes' => __('messages.validation.image_format'),
            'image.max' => __('messages.validation.image_size', ['max' => 2]),
        ];
    }
}

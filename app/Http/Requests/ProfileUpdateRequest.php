<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'vehicle_make' => ['nullable', 'string', 'max:255'],
            'vehicle_model' => ['nullable', 'string', 'max:255'],
            'vehicle_year' => ['nullable', 'string', 'max:4'],
            'vehicle_color' => ['nullable', 'string', 'max:50'],
            'vehicle_plate' => ['nullable', 'string', 'max:20'],
            'vehicle_notes' => ['nullable', 'string', 'max:1000'],
            'vehicle_fuel_type' => ['nullable', 'string', 'in:petrol,diesel,electric,hybrid'],
            'vehicle_transmission' => ['nullable', 'string', 'in:manual,automatic,semi-automatic'],
            'vehicle_engine_size' => ['nullable', 'string', 'max:50'],
            'vehicle_mileage' => ['nullable', 'integer', 'min:0'],
        ];
    }
}

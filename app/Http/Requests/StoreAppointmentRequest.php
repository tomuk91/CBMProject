<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'service' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
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
            'name.required' => __('messages.validation.name_required'),
            'name.max' => __('messages.validation.name_max', ['max' => 255]),
            'email.required' => __('messages.validation.email_required'),
            'email.email' => __('messages.validation.email_valid'),
            'email.max' => __('messages.validation.email_max', ['max' => 255]),
            'phone.required' => __('messages.validation.phone_required'),
            'phone.max' => __('messages.validation.phone_max', ['max' => 20]),
            'service.required' => __('messages.validation.service_required'),
            'service.max' => __('messages.validation.max_length', ['max' => 255]),
            'notes.max' => __('messages.validation.notes_max', ['max' => 1000]),
            'vehicle_id.exists' => 'The selected vehicle is invalid.',
        ];
    }
}

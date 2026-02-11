<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordRequest extends FormRequest
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
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
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
            'current_password.required' => __('messages.validation.required'),
            'current_password.current_password' => 'The current password is incorrect.',
            'password.required' => __('messages.validation.required'),
            'password.confirmed' => __('messages.validation.password_confirmed'),
            'password.min' => __('messages.validation.password_min', ['min' => 8]),
            'password.mixed_case' => __('messages.validation.password_mixed_case'),
            'password.numbers' => __('messages.validation.password_numbers'),
            'password.symbols' => __('messages.validation.password_symbols'),
            'password.uncompromised' => __('messages.validation.password_uncompromised'),
        ];
    }
}

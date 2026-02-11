<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
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
            'name' => 'required|string|max:255|regex:/^[\p{L}\s\-\']+$/u',
            'email' => 'required|email:rfc,dns|max:255',
            'phone' => 'nullable|string|max:20|regex:/^[+]?[0-9\s\-()]+$/',
            'subject' => 'required|string|in:service_inquiry,booking_inquiry,general_inquiry,feedback,other',
            'message' => 'required|string|max:2000|min:10',
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
            'name.regex' => __('messages.validation.name_regex'),
            'email.required' => __('messages.validation.email_required'),
            'email.email' => __('messages.validation.email_valid'),
            'email.max' => __('messages.validation.email_max', ['max' => 255]),
            'phone.max' => __('messages.validation.phone_max', ['max' => 20]),
            'phone.regex' => __('messages.validation.phone_format'),
            'subject.required' => __('messages.validation.required'),
            'subject.in' => __('messages.validation.subject_invalid'),
            'message.required' => __('messages.validation.required'),
            'message.max' => __('messages.validation.max_length', ['max' => 2000]),
            'message.min' => __('messages.validation.message_min', ['min' => 10]),
        ];
    }
}

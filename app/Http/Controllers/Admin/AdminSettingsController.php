<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminSettingsController extends Controller
{
    /**
     * Display application settings overview.
     * Read-only view of environment-driven configuration.
     */
    public function index()
    {
        $settings = [
            [
                'label' => __('messages.admin_settings_app_name'),
                'value' => config('app.name'),
            ],
            [
                'label' => __('messages.admin_settings_timezone'),
                'value' => config('app.timezone'),
            ],
            [
                'label' => __('messages.admin_settings_locale'),
                'value' => strtoupper(config('app.locale')),
            ],
            [
                'label' => __('messages.admin_settings_mail_from'),
                'value' => config('mail.from.address'),
            ],
            [
                'label' => __('messages.admin_settings_mail_name'),
                'value' => config('mail.from.name'),
            ],
        ];

        return view('admin.settings.index', compact('settings'));
    }
}

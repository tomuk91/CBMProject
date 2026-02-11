<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'app_name' => config('app.name'),
            'timezone' => config('app.timezone'),
            'locale' => config('app.locale'),
            'mail_from' => config('mail.from.address'),
            'mail_from_name' => config('mail.from.name'),
        ];

        return view('admin.settings.index', compact('settings'));
    }
}

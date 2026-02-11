<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('messages.admin_schedule_for', ['date' => $date]) }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, Helvetica, sans-serif; color: #1a1a1a; padding: 20px; font-size: 14px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 3px solid #dc2626; padding-bottom: 15px; }
        .header h1 { font-size: 24px; color: #dc2626; margin-bottom: 5px; }
        .header p { font-size: 16px; color: #555; }
        .date-picker { display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 20px; }
        .date-picker input { padding: 8px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; }
        .date-picker button { padding: 8px 16px; background: #dc2626; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; }
        .date-picker button:hover { background: #b91c1c; }
        .print-btn { display: inline-flex; align-items: center; gap: 6px; padding: 10px 20px; background: #dc2626; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; margin-bottom: 20px; }
        .print-btn:hover { background: #b91c1c; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #dc2626; color: white; padding: 10px 12px; text-align: left; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
        td { padding: 10px 12px; border-bottom: 1px solid #e5e5e5; }
        tr:nth-child(even) { background: #f9fafb; }
        .empty { text-align: center; padding: 40px; color: #888; font-size: 16px; }
        .status { display: inline-block; padding: 2px 8px; border-radius: 10px; font-size: 11px; font-weight: 600; }
        .status-confirmed { background: #dbeafe; color: #1d4ed8; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .footer { margin-top: 30px; text-align: center; font-size: 11px; color: #aaa; border-top: 1px solid #e5e5e5; padding-top: 10px; }
        @media print {
            .no-print { display: none !important; }
            body { padding: 10px; }
            th { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            tr:nth-child(even) { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ config('app.name') }} — {{ __('messages.admin_daily_schedule') }}</h1>
        <p>{{ __('messages.admin_schedule_for', ['date' => \Carbon\Carbon::parse($date)->format('l, F j, Y')]) }}</p>
    </div>

    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <form method="GET" action="{{ route('admin.appointments.print-schedule') }}" class="date-picker">
            <label for="date">{{ __('messages.date') }}:</label>
            <input type="date" id="date" name="date" value="{{ $date }}">
            <button type="submit">{{ __('messages.action_filter') }}</button>
        </form>
        <button onclick="window.print()" class="print-btn">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            {{ __('messages.admin_print_schedule') }}
        </button>
    </div>

    @if($appointments->count())
        <table>
            <thead>
                <tr>
                    <th>{{ __('messages.time') }}</th>
                    <th>{{ __('messages.name') }}</th>
                    <th>{{ __('messages.service_required') }}</th>
                    <th>{{ __('messages.appointments_vehicle_info') }}</th>
                    <th>{{ __('messages.phone') }}</th>
                    <th>{{ __('messages.status') }}</th>
                    <th>{{ __('messages.appointments_notes') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->appointment_date->format('H:i') }} - {{ $appointment->appointment_end->format('H:i') }}</td>
                        <td>{{ $appointment->name }}</td>
                        <td>{{ $appointment->service }}</td>
                        <td>{{ $appointment->vehicle }}</td>
                        <td>{{ $appointment->phone ?? '—' }}</td>
                        <td>
                            @php $statusVal = $appointment->status instanceof \App\Enums\AppointmentStatus ? $appointment->status->value : $appointment->status; @endphp
                            <span class="status status-{{ $statusVal }}">{{ ucfirst($statusVal) }}</span>
                        </td>
                        <td>{{ Str::limit($appointment->notes, 50) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty">
            <p>{{ __('messages.admin_no_appointments_for_date') }}</p>
        </div>
    @endif

    <div class="footer">
        {{ __('messages.admin_schedule_for', ['date' => $date]) }} — {{ config('app.name') }} — {{ now()->format('Y-m-d H:i') }}
    </div>
</body>
</html>

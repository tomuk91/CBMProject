<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.email_appointment_confirmation_subject') }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 3px solid #dc2626;
        }
        .header h1 {
            color: #dc2626;
            margin: 0;
            font-size: 28px;
        }
        .content {
            padding: 30px 0;
        }
        .appointment-details {
            background-color: #f9fafb;
            border-left: 4px solid #dc2626;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .detail-row {
            padding: 8px 0;
            display: flex;
            border-bottom: 1px solid #e5e7eb;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: #4b5563;
            min-width: 120px;
        }
        .detail-value {
            color: #1f2937;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #dc2626;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin: 20px 0;
        }
        .note-box {
            background-color: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>✓ {{ __('messages.email_appointment_confirmed') }}</h1>
        </div>
        
        <div class="content">
            <p>{{ __('messages.email_greeting', ['name' => $appointment->name]) }}</p>
            
            <p>{{ __('messages.email_confirmation_message') }}</p>
            
            <div class="appointment-details">
                <div class="detail-row">
                    <span class="detail-label">{{ __('messages.service') }}:</span>
                    <span class="detail-value">{{ $appointment->service }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">{{ __('messages.date') }}:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">{{ __('messages.time') }}:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('g:i A') }}</span>
                </div>
                @if($appointment->vehicle_id && $appointment->vehicle)
                    <div class="detail-row">
                        <span class="detail-label">{{ __('messages.vehicle') }}:</span>
                        <span class="detail-value">{{ $appointment->vehicle->full_name }}</span>
                    </div>
                @elseif($appointment->vehicle)
                    <div class="detail-row">
                        <span class="detail-label">{{ __('messages.vehicle') }}:</span>
                        <span class="detail-value">{{ $appointment->vehicle }}</span>
                    </div>
                @endif
                <div class="detail-row">
                    <span class="detail-label">{{ __('messages.status') }}:</span>
                    <span class="detail-value">
                        <span class="status-badge status-pending">{{ __('messages.status_' . $appointment->status) }}</span>
                    </span>
                </div>
            </div>
            
            @if($appointment->notes)
                <div class="note-box">
                    <strong>{{ __('messages.your_notes') }}:</strong>
                    <p style="margin: 5px 0 0 0;">{{ $appointment->notes }}</p>
                </div>
            @endif
            
            <p>{{ __('messages.email_pending_notice') }}</p>
            
            <center>
                <a href="{{ url('/dashboard') }}" class="button">{{ __('messages.view_dashboard') }}</a>
            </center>
            
            <p>{{ __('messages.email_questions') }}</p>
        </div>
        
        <div class="footer">
            <p>{{ config('app.name') }}</p>
            <p>{{ __('messages.email_automated_message') }}</p>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.email_status_changed_subject') }}</title>
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
        .status-change {
            background-color: #f0fdf4;
            border: 2px solid #16a34a;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            text-align: center;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            margin: 0 5px;
        }
        .status-approved {
            background-color: #d1fae5;
            color: #065f46;
        }
        .status-confirmed {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .status-completed {
            background-color: #d1fae5;
            color: #065f46;
        }
        .status-cancelled {
            background-color: #fee2e2;
            color: #991b1b;
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
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>📋 {{ __('messages.email_status_update') }}</h1>
        </div>
        
        <div class="content">
            <p>{{ __('messages.email_greeting', ['name' => $appointment->name]) }}</p>
            
            <p>{{ __('messages.email_status_changed_message') }}</p>
            
            <div class="status-change">
                <span class="status-badge">{{ __('messages.status_' . $oldStatus) }}</span>
                <span style="font-size: 24px;">→</span>
                <span class="status-badge status-{{ $appointment->status }}">{{ __('messages.status_' . $appointment->status) }}</span>
            </div>
            
            <div class="appointment-details">
                <div class="detail-row">
                    <span class="detail-label">{{ __('messages.service') }}:</span>
                    <span class="detail-value">{{ $appointment->service }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">{{ __('messages.date') }}:</span>
                    <span class="detail-value">{{ $appointment->appointment_date->format('F d, Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">{{ __('messages.time') }}:</span>
                    <span class="detail-value">{{ $appointment->appointment_date->format('g:i A') }}</span>
                </div>
            </div>
            
            @if($appointment->status === 'approved')
                <p><strong>{{ __('messages.email_approved_notice') }}</strong></p>
            @elseif($appointment->status === 'confirmed')
                <p><strong>{{ __('messages.email_confirmed_notice') }}</strong></p>
            @elseif($appointment->status === 'completed')
                <p>{{ __('messages.email_completed_thanks') }}</p>
            @elseif($appointment->status === 'cancelled')
                <p>{{ __('messages.email_cancelled_notice') }}</p>
            @endif
            
            <center>
                <a href="{{ url('/dashboard') }}" class="button">{{ __('messages.view_dashboard') }}</a>
            </center>
        </div>
        
        <div class="footer">
            <p>{{ config('app.name') }}</p>
            <p>{{ __('messages.email_automated_message') }}</p>
        </div>
    </div>
</body>
</html>

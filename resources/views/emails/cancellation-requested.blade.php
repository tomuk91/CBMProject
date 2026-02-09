<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.email_cancellation_requested_subject') }}</title>
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
        .alert-box {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
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
            min-width: 140px;
        }
        .detail-value {
            color: #1f2937;
            flex: 1;
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
        .reason-box {
            background-color: #fee2e2;
            border-left: 4px solid #dc2626;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>⚠️ {{ __('messages.email_cancellation_request') }}</h1>
        </div>
        
        <div class="content">
            <div class="alert-box">
                <strong>{{ __('messages.email_action_required') }}</strong>
                <p style="margin: 5px 0 0 0;">{{ __('messages.email_cancellation_review') }}</p>
            </div>
            
            <div class="appointment-details">
                <div class="detail-row">
                    <span class="detail-label">{{ __('messages.customer_name') }}:</span>
                    <span class="detail-value">{{ $appointment->name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">{{ __('messages.email') }}:</span>
                    <span class="detail-value">{{ $appointment->email }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">{{ __('messages.phone') }}:</span>
                    <span class="detail-value">{{ $appointment->phone }}</span>
                </div>
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
                <div class="detail-row">
                    <span class="detail-label">{{ __('messages.requested_at') }}:</span>
                    <span class="detail-value">{{ $appointment->cancellation_requested_at->format('F d, Y g:i A') }}</span>
                </div>
            </div>
            
            @if($appointment->cancellation_reason)
                <div class="reason-box">
                    <strong>{{ __('messages.cancellation_reason') }}:</strong>
                    <p style="margin: 5px 0 0 0;">{{ $appointment->cancellation_reason }}</p>
                </div>
            @endif
            
            <center>
                <a href="{{ url('/admin/appointments') }}" class="button">{{ __('messages.review_request') }}</a>
            </center>
        </div>
        
        <div class="footer">
            <p>{{ config('app.name') }}</p>
            <p>{{ __('messages.email_automated_message') }}</p>
        </div>
    </div>
</body>
</html>

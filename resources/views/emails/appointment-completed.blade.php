<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.email_completed_heading') }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f3f4f6;">
    <table role="presentation" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table role="presentation" style="width: 600px; border-collapse: collapse; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); padding: 40px 30px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: bold;">✅ {{ __('messages.email_completed_heading') }}</h1>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="margin: 0 0 20px; color: #374151; font-size: 16px; line-height: 1.6;">
                                {{ __('messages.email_dear', ['name' => $appointment->name]) }}
                            </p>
                            
                            <p style="margin: 0 0 20px; color: #374151; font-size: 16px; line-height: 1.6;">
                                {{ __('messages.email_completed_body') }}
                            </p>
                            
                            <!-- Service Details Box -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f0fdf4; border-radius: 8px; margin: 30px 0; border: 1px solid #bbf7d0;">
                                <tr>
                                    <td style="padding: 25px;">
                                        <h2 style="margin: 0 0 20px; color: #111827; font-size: 18px; font-weight: bold;">{{ __('messages.email_completed_details_title') }}</h2>
                                        
                                        <table role="presentation" style="width: 100%; border-collapse: collapse;">
                                            <tr>
                                                <td style="padding: 8px 0; color: #6b7280; font-size: 14px; width: 120px;">{{ __('messages.email_label_service') }}</td>
                                                <td style="padding: 8px 0; color: #111827; font-size: 14px; font-weight: 600;">{{ $appointment->service }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">{{ __('messages.email_label_date_time') }}</td>
                                                <td style="padding: 8px 0; color: #111827; font-size: 14px; font-weight: 600;">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F j, Y \\a\\t g:i A') }}</td>
                                            </tr>
                                            @if($appointment->vehicle_description)
                                            <tr>
                                                <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">{{ __('messages.email_label_vehicle') }}</td>
                                                <td style="padding: 8px 0; color: #111827; font-size: 14px; font-weight: 600;">{{ $appointment->vehicle_description }}</td>
                                            </tr>
                                            @endif
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- CTA Button -->
                            <table role="presentation" style="margin: 30px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ url('/appointments') }}" style="display: inline-block; padding: 14px 32px; background-color: #16a34a; color: #ffffff; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 16px;">{{ __('messages.email_completed_cta') }}</a>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="margin: 30px 0 0; color: #6b7280; font-size: 14px; line-height: 1.6;">
                                {{ __('messages.email_completed_thanks', ['app' => config('app.name')]) }}
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="padding: 30px; background-color: #f9fafb; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0 0 10px; color: #111827; font-size: 16px; font-weight: 600;">{{ config('app.name') }}</p>
                            <p style="margin: 0 0 5px; color: #6b7280; font-size: 14px;">{{ config('services.business.phone', '+36 1 234 5678') }}</p>
                            <p style="margin: 0 0 5px; color: #6b7280; font-size: 14px;">{{ config('services.business.email', 'info@cbmauto.com') }}</p>
                            <p style="margin: 0; color: #6b7280; font-size: 14px;">{{ config('services.business.address', 'Budapest, Hungary') }}</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

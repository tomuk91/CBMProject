<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.email_mot_reminder_heading') }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f3f4f6;">
    <table role="presentation" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table role="presentation" style="width: 600px; border-collapse: collapse; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #dc2626; background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%); padding: 40px 30px; text-align: center;">
                            <div style="font-size: 48px; margin-bottom: 15px;">⏰</div>
                            <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: bold;">{{ __('messages.email_mot_reminder_heading') }}</h1>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="margin: 0 0 20px; color: #374151; font-size: 16px; line-height: 1.6;">
                                {{ __('messages.email_dear', ['name' => $appointment->name]) }}
                            </p>
                            
                            <p style="margin: 0 0 20px; color: #374151; font-size: 16px; line-height: 1.6;">
                                {{ __('messages.email_mot_reminder_body') }}
                            </p>
                            
                            <!-- MOT Details Box -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #fef2f2; border-radius: 8px; margin: 30px 0; border: 1px solid #fecaca;">
                                <tr>
                                    <td style="padding: 25px;">
                                        <h2 style="margin: 0 0 20px; color: #111827; font-size: 18px; font-weight: bold;">{{ __('messages.email_mot_reminder_details_title') }}</h2>
                                        
                                        <table role="presentation" style="width: 100%; border-collapse: collapse;">
                                            <tr>
                                                <td style="padding: 8px 0; color: #6b7280; font-size: 14px; width: 120px;">{{ __('messages.email_label_service') }}</td>
                                                <td style="padding: 8px 0; color: #111827; font-size: 14px; font-weight: 600;">MOT Service</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">{{ __('messages.email_label_date_completed') }}</td>
                                                <td style="padding: 8px 0; color: #111827; font-size: 14px; font-weight: 600;">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F j, Y') }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">{{ __('messages.email_label_expires') }}</td>
                                                <td style="padding: 8px 0; color: #dc2626; font-size: 14px; font-weight: 600;">{{ \Carbon\Carbon::parse($appointment->appointment_date)->addYear()->format('l, F j, Y') }}</td>
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

                            <p style="margin: 0 0 20px; color: #374151; font-size: 16px; line-height: 1.6;">
                                {{ __('messages.email_mot_reminder_action') }}
                            </p>
                            
                            <!-- CTA Button -->
                            <table role="presentation" style="margin: 30px 0; border-collapse: collapse;">
                                <tr>
                                    <td style="text-align: center;">
                                        <a href="{{ route('appointments.index') }}" style="display: inline-block; background-color: #dc2626; color: #ffffff; padding: 12px 30px; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 16px;">
                                            {{ __('messages.email_cta_book_mot') }}
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 20px 0 0; color: #6b7280; font-size: 14px; line-height: 1.6;">
                                {{ __('messages.email_regards') }}
                                <br><strong>{{ config('app.name') }} Team</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9fafb; padding: 20px 30px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0; color: #9ca3af; font-size: 12px;">
                                © {{ date('Y') }} {{ config('app.name') }}. {{ __('messages.email_footer') }}
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

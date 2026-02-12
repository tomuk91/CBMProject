<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Reminder</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="background-color: #f4f4f4; padding: 20px;">
        <tr>
            <td align="center">
                <table cellpadding="0" cellspacing="0" border="0" width="600" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%); padding: 40px 30px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: bold;">
                                🔔 {{ __('messages.appointment_reminder_title') }}
                            </h1>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="margin: 0 0 20px; font-size: 16px; line-height: 1.6; color: #333333;">
                                {{ __('messages.hello') }} <strong>{{ $appointment->name }}</strong>,
                            </p>

                            <p style="margin: 0 0 30px; font-size: 16px; line-height: 1.6; color: #333333;">
                                {{ __('messages.appointment_reminder_message') }}
                            </p>

                            <!-- Appointment Details Box -->
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="background-color: #f9fafb; border-radius: 8px; padding: 25px; margin-bottom: 30px;">
                                <tr>
                                    <td>
                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                            <tr>
                                                <td style="padding: 8px 0; font-size: 14px; color: #6b7280;">
                                                    <strong style="color: #374151;">📅 {{ __('messages.date') }}:</strong>
                                                </td>
                                                <td style="padding: 8px 0; font-size: 14px; color: #1f2937; text-align: right;">
                                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F j, Y') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; font-size: 14px; color: #6b7280;">
                                                    <strong style="color: #374151;">🕐 {{ __('messages.time') }}:</strong>
                                                </td>
                                                <td style="padding: 8px 0; font-size: 14px; color: #1f2937; text-align: right;">
                                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('H:i') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; font-size: 14px; color: #6b7280;">
                                                    <strong style="color: #374151;">🔧 {{ __('messages.service') }}:</strong>
                                                </td>
                                                <td style="padding: 8px 0; font-size: 14px; color: #1f2937; text-align: right;">
                                                    {{ $appointment->service }}
                                                </td>
                                            </tr>
                                            @if($appointment->vehicle_description)
                                            <tr>
                                                <td style="padding: 8px 0; font-size: 14px; color: #6b7280;">
                                                    <strong style="color: #374151;">🚗 {{ __('messages.vehicle') }}:</strong>
                                                </td>
                                                <td style="padding: 8px 0; font-size: 14px; color: #1f2937; text-align: right;">
                                                    {{ $appointment->vehicle_description }}
                                                </td>
                                            </tr>
                                            @endif
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Call to Action -->
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-bottom: 30px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ route('dashboard') }}" style="display: inline-block; padding: 14px 32px; background-color: #dc2626; color: #ffffff; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 16px;">
                                            {{ __('messages.view_appointment_details') }}
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Info Box -->
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
                                <tr>
                                    <td style="font-size: 14px; line-height: 1.6; color: #92400e;">
                                        <strong>⚠️ {{ __('messages.important') }}:</strong> {{ __('messages.appointment_reminder_note') }}
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0; font-size: 14px; line-height: 1.6; color: #6b7280;">
                                {{ __('messages.thank_you_business') }}<br>
                                <strong>CBM Auto</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9fafb; padding: 20px 30px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0 0 10px; font-size: 12px; color: #6b7280;">
                                CBM Auto - {{ __('messages.your_trusted_service') }}
                            </p>
                            <p style="margin: 0; font-size: 12px; color: #6b7280;">
                                📞 +36 1 234 5678 | 📧 info@cbmauto.com
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

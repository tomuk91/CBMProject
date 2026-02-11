<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.export_page_title') }} - {{ config('app.name') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
            background: #f9fafb;
        }
        
        .header {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            color: white;
            padding: 40px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 10px 25px rgba(220, 38, 38, 0.2);
        }
        
        .header h1 {
            font-size: 32px;
            margin-bottom: 10px;
        }
        
        .header p {
            opacity: 0.9;
            font-size: 14px;
        }
        
        .section {
            background: white;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }
        
        .section h2 {
            color: #dc2626;
            font-size: 24px;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid #fee2e2;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .info-item {
            padding: 15px;
            background: #f9fafb;
            border-radius: 8px;
            border-left: 3px solid #dc2626;
        }
        
        .info-label {
            font-size: 12px;
            text-transform: uppercase;
            color: #6b7280;
            font-weight: 600;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }
        
        .info-value {
            font-size: 16px;
            color: #111827;
            font-weight: 500;
        }
        
        .info-value.empty {
            color: #9ca3af;
            font-style: italic;
        }
        
        .card {
            background: #f9fafb;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            border: 1px solid #e5e7eb;
        }
        
        .card h3 {
            color: #374151;
            font-size: 18px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        
        .card h3::before {
            content: "●";
            color: #dc2626;
            margin-right: 10px;
            font-size: 24px;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .badge.confirmed {
            background: #d1fae5;
            color: #065f46;
        }
        
        .badge.pending {
            background: #fef3c7;
            color: #92400e;
        }
        
        .badge.completed {
            background: #dbeafe;
            color: #1e40af;
        }
        
        .badge.cancelled {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .footer {
            text-align: center;
            margin-top: 40px;
            padding: 20px;
            color: #6b7280;
            font-size: 14px;
        }
        
        .print-button {
            background: #dc2626;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(220, 38, 38, 0.2);
            transition: all 0.3s ease;
        }
        
        .print-button:hover {
            background: #b91c1c;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(220, 38, 38, 0.3);
        }
        
        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .print-button {
                display: none;
            }
            
            .section {
                page-break-inside: avoid;
                box-shadow: none;
                border: 1px solid #e5e7eb;
            }
        }
        
        @media (max-width: 768px) {
            .header h1 {
                font-size: 24px;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <button class="print-button" onclick="window.print()">🖨️ {{ __('messages.export_print_button') }}</button>
    
    <div class="header">
        <h1>📄 {{ __('messages.export_my_personal_data') }}</h1>
        <p>{{ __('messages.export_exported_on') }} {{ now()->format('F j, Y \a\t g:i A') }}</p>
        <p>{{ __('messages.export_from') }} {{ config('app.name') }}</p>
    </div>

    <!-- Personal Information -->
    <div class="section">
        <h2>👤 {{ __('messages.export_personal_information') }}</h2>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">{{ __('messages.export_full_name') }}</div>
                <div class="info-value">{{ $user->name }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">{{ __('messages.export_email_address') }}</div>
                <div class="info-value">{{ $user->email }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">{{ __('messages.export_phone_number') }}</div>
                <div class="info-value">{{ $user->phone ?? __('messages.export_not_provided') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">{{ __('messages.export_address') }}</div>
                <div class="info-value">{{ $user->address ?? __('messages.export_not_provided') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">{{ __('messages.export_city') }}</div>
                <div class="info-value">{{ $user->city ?? __('messages.export_not_provided') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">{{ __('messages.export_postal_code') }}</div>
                <div class="info-value">{{ $user->postal_code ?? __('messages.export_not_provided') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">{{ __('messages.export_country') }}</div>
                <div class="info-value">{{ $user->country ?? __('messages.export_not_provided') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">{{ __('messages.export_account_created') }}</div>
                <div class="info-value">{{ $user->created_at->format('F j, Y') }}</div>
            </div>
        </div>
    </div>

    <!-- Vehicles -->
    <div class="section">
        <h2>🚗 {{ __('messages.export_my_vehicles') }}</h2>
        @if($user->vehicles->count() > 0)
            @foreach($user->vehicles as $vehicle)
                <div class="card">
                    <h3>{{ $vehicle->make }} {{ $vehicle->model }} ({{ $vehicle->year }})</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">{{ __('messages.export_license_plate') }}</div>
                            <div class="info-value">{{ $vehicle->plate }}</div>
                        </div>
                        @if($vehicle->vin)
                        <div class="info-item">
                            <div class="info-label">{{ __('messages.export_vin') }}</div>
                            <div class="info-value">{{ $vehicle->vin }}</div>
                        </div>
                        @endif
                        @if($vehicle->color)
                        <div class="info-item">
                            <div class="info-label">{{ __('messages.export_color') }}</div>
                            <div class="info-value">{{ $vehicle->color }}</div>
                        </div>
                        @endif
                        @if($vehicle->mileage)
                        <div class="info-item">
                            <div class="info-label">{{ __('messages.export_mileage') }}</div>
                            <div class="info-value">{{ number_format($vehicle->mileage) }} km</div>
                        </div>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <p class="info-value empty">{{ __('messages.export_no_vehicles') }}</p>
        @endif
    </div>

    <!-- Appointments -->
    <div class="section">
        <h2>📅 {{ __('messages.export_appointment_history') }}</h2>
        @if($user->appointments->count() > 0)
            @foreach($user->appointments->sortByDesc('appointment_date') as $appointment)
                <div class="card">
                    <h3>
                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}
                        <span class="badge {{ $appointment->status->value }}">{{ ucfirst($appointment->status->value) }}</span>
                    </h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">{{ __('messages.export_service_type') }}</div>
                            <div class="info-value">{{ $appointment->service ?? __('messages.export_general_service') }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">{{ __('messages.export_date_time') }}</div>
                            <div class="info-value">
                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y \a\t g:i A') }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">{{ __('messages.export_vehicle') }}</div>
                            <div class="info-value">{{ $appointment->vehicle ?? __('messages.export_not_specified') }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">{{ __('messages.export_status') }}</div>
                            <div class="info-value">{{ ucfirst($appointment->status->value) }}</div>
                        </div>
                        @if($appointment->notes)
                        <div class="info-item" style="grid-column: 1 / -1;">
                            <div class="info-label">{{ __('messages.export_notes') }}</div>
                            <div class="info-value">{{ $appointment->notes }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <p class="info-value empty">{{ __('messages.export_no_appointments') }}</p>
        @endif
    </div>

    <!-- Data Rights Information -->
    <div class="section">
        <h2>ℹ️ {{ __('messages.export_data_rights_title') }}</h2>
        <p style="color: #6b7280; line-height: 1.8;">
            {{ __('messages.export_gdpr_intro') }}
        </p>
        <ul style="margin-top: 15px; margin-left: 20px; color: #6b7280; line-height: 2;">
            <li>{{ __('messages.export_right_corrections') }}</li>
            <li>{{ __('messages.export_right_deletion') }}</li>
            <li>{{ __('messages.export_right_withdraw') }}</li>
            <li>{{ __('messages.export_right_portability') }}</li>
        </ul>
        <p style="margin-top: 15px; color: #6b7280;">
            {{ __('messages.export_data_contact') }}
            <strong>{{ config('services.business.email') }}</strong>
        </p>
    </div>

    <div class="footer">
        <p>{{ __('messages.export_generated_by') }} {{ config('app.name') }}</p>
        <p style="margin-top: 10px;">{{ now()->format('F j, Y \a\t g:i A') }}</p>
    </div>
</body>
</html>

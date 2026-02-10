<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\PendingAppointment;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\ActivityLog;
use App\Models\AvailableSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    /**
     * Display analytics dashboard
     */
    public function index(Request $request)
    {
        $period = $request->get('period', '30'); // 7, 30, 90 days
        $startDate = Carbon::now()->subDays($period);

        // Overview Statistics
        $stats = [
            'total_users' => User::count(),
            'new_users_period' => User::where('created_at', '>=', $startDate)->count(),
            
            'total_appointments' => Appointment::count(),
            'pending_appointments' => PendingAppointment::where('status', 'pending')->count(),
            'approved_appointments' => Appointment::where('status', 'approved')->count(),
            'completed_appointments' => Appointment::where('status', 'completed')->count(),
            'cancelled_appointments' => Appointment::onlyTrashed()->count(),
            
            'appointments_period' => Appointment::where('created_at', '>=', $startDate)->count(),
            'cancellation_requests' => Appointment::where('cancellation_requested', true)
                ->whereNull('deleted_at')
                ->count(),
            
            'total_vehicles' => Vehicle::count(),
            'available_slots' => AvailableSlot::where('status', 'available')->count(),
        ];

        // Appointments by Status (for pie chart)
        $appointmentsByStatus = Appointment::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        // Appointments Over Time (for line chart)
        $appointmentsOverTime = Appointment::where('created_at', '>=', $startDate)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top Services
        $topServices = Appointment::select('service', DB::raw('count(*) as count'))
            ->where('created_at', '>=', $startDate)
            ->groupBy('service')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        // Recent Activity
        $recentActivity = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Busiest Days of Week
        $busiestDays = Appointment::select(
                DB::raw('CASE 
                    WHEN DAYOFWEEK(appointment_date) = 1 THEN 7
                    ELSE DAYOFWEEK(appointment_date) - 1
                END as day_of_week'),
                DB::raw('count(*) as count')
            )
            ->where('created_at', '>=', $startDate)
            ->groupBy('day_of_week')
            ->orderBy('day_of_week')
            ->get()
            ->map(function($item) {
                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                $item->day_name = $days[$item->day_of_week - 1];
                return $item;
            });

        // Busiest Times of Day
        $busiestTimes = Appointment::select(
                DB::raw('HOUR(appointment_date) as hour'),
                DB::raw('count(*) as count')
            )
            ->where('created_at', '>=', $startDate)
            ->groupBy('hour')
            ->orderBy('hour')
            ->get()
            ->map(function($item) {
                $item->time_label = str_pad($item->hour, 2, '0', STR_PAD_LEFT) . ':00';
                return $item;
            });

        // No-show rate (appointments marked as no-show vs completed)
        $noShowRate = 0;
        $totalCompleted = Appointment::whereIn('status', ['completed', 'no-show'])->count();
        if ($totalCompleted > 0) {
            $noShows = Appointment::where('status', 'no-show')->count();
            $noShowRate = round(($noShows / $totalCompleted) * 100, 1);
        }

        // Average time to approval (pending to approved)
        $avgApprovalTime = DB::table('activity_logs')
            ->where('activity_logs.action', 'appointment_approved')
            ->where('activity_logs.created_at', '>=', $startDate)
            ->join('pending_appointments', 'activity_logs.model_id', '=', 'pending_appointments.id')
            ->select(DB::raw('AVG(julianday(activity_logs.created_at) - julianday(pending_appointments.created_at)) * 24 as hours'))
            ->value('hours');

        return view('admin.analytics.index', compact(
            'stats',
            'appointmentsByStatus',
            'appointmentsOverTime',
            'topServices',
            'recentActivity',
            'busiestDays',
            'busiestTimes',
            'noShowRate',
            'avgApprovalTime',
            'period'
        ));
    }

    /**
     * Export analytics data
     */
    public function export(Request $request)
    {
        $period = $request->get('period', '30');
        $startDate = Carbon::now()->subDays($period);

        $appointments = Appointment::with(['user', 'vehicle'])
            ->where('created_at', '>=', $startDate)
            ->get();

        // Generate CSV
        $filename = 'analytics_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($appointments) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, [
                'ID',
                'Date',
                'Time',
                'Customer',
                'Email',
                'Phone',
                'Service',
                'Vehicle',
                'Status',
                'Created At'
            ]);

            // Data rows
            foreach ($appointments as $appointment) {
                // Handle vehicle data - could be relationship or string field
                $vehicleData = 'N/A';
                if ($appointment->vehicle_id && $appointment->vehicle && is_object($appointment->vehicle)) {
                    $vehicleData = "{$appointment->vehicle->make} {$appointment->vehicle->model}";
                } elseif (!empty($appointment->vehicle) && is_string($appointment->vehicle)) {
                    $vehicleData = $appointment->vehicle;
                }
                
                fputcsv($file, [
                    $appointment->id,
                    Carbon::parse($appointment->appointment_date)->format('Y-m-d'),
                    Carbon::parse($appointment->appointment_date)->format('H:i'),
                    $appointment->name,
                    $appointment->email,
                    $appointment->phone,
                    $appointment->service,
                    $vehicleData,
                    $appointment->status,
                    $appointment->created_at->format('Y-m-d H:i'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

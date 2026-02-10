<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\AnalyticsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Models\Appointment;

// Language switcher
Route::get('/language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'hu'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('language.switch');

// Sitemap
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::get('/', function () {
    return view('home');
})->name('home');

// About page
Route::get('/about', function () {
    return view('about');
})->name('about');

// Privacy Policy
Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

// Terms of Service
Route::get('/terms', function () {
    return view('terms');
})->name('terms');

// Contact form
Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'submit'])
    ->middleware('throttle:10,60')
    ->name('contact.submit');

// Guest appointment slot selection (before login)
Route::get('/slots', [AppointmentController::class, 'guestSlots'])->name('guest.slots');
Route::post('/slots/{slot}/select', [AppointmentController::class, 'selectGuestSlot'])->name('guest.slots.select');

Route::get('/dashboard', function () {
    $appointments = Appointment::with('vehicle')
        ->where('user_id', Auth::id())
        ->where('status', '!=', 'completed')
        ->orderBy('appointment_date', 'desc')
        ->get();
    
    $serviceHistory = Appointment::with('vehicle')
        ->where('user_id', Auth::id())
        ->where('status', 'completed')
        ->orderBy('appointment_date', 'desc')
        ->take(10)
        ->get();
    
    return view('dashboard', [
        'appointments' => $appointments,
        'serviceHistory' => $serviceHistory
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/personal-info', [ProfileController::class, 'edit'])->name('profile.personal-info');
    Route::get('/profile/vehicle', [ProfileController::class, 'edit'])->name('profile.vehicle');
    Route::get('/profile/security', [ProfileController::class, 'edit'])->name('profile.security');
    Route::get('/profile/service-history', function () {
        $serviceHistory = \App\Models\Appointment::with('vehicle')
            ->where('user_id', Auth::id())
            ->where('status', 'completed')
            ->orderBy('appointment_date', 'desc')
            ->get();
        
        return view('profile.service-history', ['serviceHistory' => $serviceHistory]);
    })->name('profile.service-history');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // GDPR: Data export and deletion
    Route::get('/profile/export-data', [ProfileController::class, 'exportData'])->name('profile.export-data');
    Route::post('/profile/request-deletion', [ProfileController::class, 'requestDeletion'])->name('profile.request-deletion');
    
    // Vehicle management routes
    Route::get('/profile/vehicles', [\App\Http\Controllers\VehicleController::class, 'index'])->name('vehicles.index');
    Route::post('/vehicles', [\App\Http\Controllers\VehicleController::class, 'store'])->name('vehicles.store');
    Route::put('/vehicles/{vehicle}', [\App\Http\Controllers\VehicleController::class, 'update'])->name('vehicles.update');
    Route::delete('/vehicles/{vehicle}', [\App\Http\Controllers\VehicleController::class, 'destroy'])->name('vehicles.destroy');
    Route::post('/vehicles/{vehicle}/set-primary', [\App\Http\Controllers\VehicleController::class, 'setPrimary'])->name('vehicles.set-primary');
    Route::get('/api/vehicles/{vehicle}', function(\App\Models\Vehicle $vehicle) {
        if ($vehicle->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to vehicle data');
        }
        
        $data = $vehicle->only(['id', 'make', 'model', 'year', 'color', 'plate', 'fuel_type', 'transmission', 'engine_size', 'mileage', 'notes', 'is_primary', 'image']);
        
        // Add temporary URL for image if exists
        if ($vehicle->image) {
            $data['image_url'] = Storage::disk(config('filesystems.default'))->temporaryUrl($vehicle->image, now()->addHours(1));
        }
        
        return response()->json($data);
    })->middleware('throttle:60,1');
    
    // Customer appointment routes
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/{slot}', [AppointmentController::class, 'show'])->name('appointments.show');
    Route::post('/appointments/{slot}/book', [AppointmentController::class, 'store'])
        ->middleware('throttle:30,60')
        ->name('appointments.store');
    Route::get('/appointments/confirmation/success', [AppointmentController::class, 'confirmation'])->name('appointments.confirmation');
    Route::post('/appointments/{appointment}/request-cancellation', [AppointmentController::class, 'requestCancellation'])->name('appointments.requestCancellation');
    Route::get('/api/check-vehicle-availability/{vehicle}', [AppointmentController::class, 'checkVehicleAvailability'])->name('api.check-vehicle-availability');
    
    // Admin appointment routes
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminAppointmentController::class, 'dashboard'])->name('dashboard');
        
        // Analytics
        Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
        Route::get('/analytics/export', [AnalyticsController::class, 'export'])->name('analytics.export');
        
        Route::get('/appointments/calendar', [AdminAppointmentController::class, 'index'])->name('appointments.calendar');
        Route::get('/appointments/pending', [AdminAppointmentController::class, 'pending'])->name('appointments.pending');
        Route::get('/appointments/slots', [AdminAppointmentController::class, 'slots'])->name('appointments.slots');
        Route::get('/appointments/activity-log', [AdminAppointmentController::class, 'activityLog'])->name('appointments.activityLog');
        Route::post('/appointments/slots/check-conflicts', [AdminAppointmentController::class, 'checkSlotConflicts'])->name('slots.check-conflicts');
        Route::post('/appointments/slots', [AdminAppointmentController::class, 'storeSlot'])->name('appointments.slots.store');
        Route::post('/appointments/slots/{slot}/book', [AdminAppointmentController::class, 'bookSlot'])->name('appointments.slots.book');
        Route::delete('/appointments/slots/{slot}', [AdminAppointmentController::class, 'destroySlot'])->name('appointments.slots.destroy');
        Route::delete('/appointments/slots/bulk-delete', [AdminAppointmentController::class, 'bulkDestroySlots'])->name('appointments.slots.bulk-delete');
        Route::get('/appointments/api', [AdminAppointmentController::class, 'getAppointments'])->name('appointments.api');
        Route::post('/appointments/pending/{pendingAppointment}/approve', [AdminAppointmentController::class, 'approve'])->name('appointments.approve');
        Route::post('/appointments/pending/{pendingAppointment}/reject', [AdminAppointmentController::class, 'reject'])->name('appointments.reject');
        Route::post('/appointments/bulk-reject', [AdminAppointmentController::class, 'bulkReject'])->name('appointments.bulk-reject');
        Route::post('/appointments/{appointment}/cancellation/approve', [AdminAppointmentController::class, 'approveCancellation'])->name('appointments.cancellation.approve');
        Route::post('/appointments/{appointment}/cancellation/deny', [AdminAppointmentController::class, 'denyCancellation'])->name('appointments.cancellation.deny');
        Route::post('/appointments/{appointment}/status', [AdminAppointmentController::class, 'updateStatus'])->name('appointments.status');
        Route::post('/appointments/{appointment}/complete', [AdminAppointmentController::class, 'complete'])->name('appointments.complete');
        Route::post('/appointments/{appointment}/update-time', [AdminAppointmentController::class, 'updateTime'])->name('appointments.updateTime');
        Route::post('/appointments/cleanup-old-slots', [AdminAppointmentController::class, 'cleanupOldSlots'])->name('appointments.cleanupOldSlots');
        Route::delete('/appointments/{appointment}', [AdminAppointmentController::class, 'destroy'])->name('appointments.destroy');
        
        // Export and Bulk Operations
        Route::get('/appointments/export', [AdminAppointmentController::class, 'exportAppointments'])->name('appointments.export');
        Route::get('/appointments/slots/export', [AdminAppointmentController::class, 'exportSlots'])->name('slots.export');
        Route::post('/appointments/bulk-email', [AdminAppointmentController::class, 'sendBulkEmail'])->name('appointments.bulk-email');
        
        // API endpoint to get user vehicles
        Route::get('/api/users/{user}/vehicles', function(\App\Models\User $user) {
            // Only return essential vehicle information
            return response()->json($user->vehicles->map(function($vehicle) {
                return $vehicle->only(['id', 'make', 'model', 'year', 'plate', 'is_primary']);
            }));
        })->middleware('throttle:60,1')->name('api.user.vehicles');
    });
});

require __DIR__.'/auth.php';

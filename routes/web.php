<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
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

Route::get('/', function () {
    return view('home');
})->name('home');

// Guest appointment slot selection (before login)
Route::get('/slots', [AppointmentController::class, 'guestSlots'])->name('guest.slots');
Route::post('/slots/{slot}/select', [AppointmentController::class, 'selectGuestSlot'])->name('guest.slots.select');

Route::get('/dashboard', function () {
    $appointments = Appointment::where('user_id', Auth::id())
        ->orderBy('appointment_date', 'desc')
        ->get();
    
    return view('dashboard', [
        'appointments' => $appointments
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/personal-info', [ProfileController::class, 'edit'])->name('profile.personal-info');
    Route::get('/profile/vehicle', [ProfileController::class, 'edit'])->name('profile.vehicle');
    Route::get('/profile/security', [ProfileController::class, 'edit'])->name('profile.security');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Vehicle management routes
    Route::get('/profile/vehicles', [\App\Http\Controllers\VehicleController::class, 'index'])->name('vehicles.index');
    Route::post('/vehicles', [\App\Http\Controllers\VehicleController::class, 'store'])->name('vehicles.store');
    Route::put('/vehicles/{vehicle}', [\App\Http\Controllers\VehicleController::class, 'update'])->name('vehicles.update');
    Route::delete('/vehicles/{vehicle}', [\App\Http\Controllers\VehicleController::class, 'destroy'])->name('vehicles.destroy');
    Route::post('/vehicles/{vehicle}/set-primary', [\App\Http\Controllers\VehicleController::class, 'setPrimary'])->name('vehicles.set-primary');
    Route::get('/api/vehicles/{vehicle}', function(\App\Models\Vehicle $vehicle) {
        if ($vehicle->user_id !== Auth::id()) {
            abort(403);
        }
        return response()->json($vehicle);
    });
    
    // Customer appointment routes
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/{slot}', [AppointmentController::class, 'show'])->name('appointments.show');
    Route::post('/appointments/{slot}/book', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/confirmation/success', [AppointmentController::class, 'confirmation'])->name('appointments.confirmation');
    
    // Admin appointment routes
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminAppointmentController::class, 'dashboard'])->name('dashboard');
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
        Route::post('/appointments/{appointment}/status', [AdminAppointmentController::class, 'updateStatus'])->name('appointments.status');
        Route::post('/appointments/{appointment}/complete', [AdminAppointmentController::class, 'complete'])->name('appointments.complete');
        Route::post('/appointments/{appointment}/update-time', [AdminAppointmentController::class, 'updateTime'])->name('appointments.updateTime');
        Route::post('/appointments/cleanup-old-slots', [AdminAppointmentController::class, 'cleanupOldSlots'])->name('appointments.cleanupOldSlots');
        Route::delete('/appointments/{appointment}', [AdminAppointmentController::class, 'destroy'])->name('appointments.destroy');
        
        // API endpoint to get user vehicles
        Route::get('/api/users/{user}/vehicles', function(\App\Models\User $user) {
            return response()->json($user->vehicles);
        })->name('api.user.vehicles');
    });
});

require __DIR__.'/auth.php';

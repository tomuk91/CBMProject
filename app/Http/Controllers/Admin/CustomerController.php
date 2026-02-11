<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('is_admin', false)
            ->withCount(['appointments' => function($q) {
                // count all appointments
            }]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        $allowedSorts = ['name', 'email', 'created_at', 'appointments_count'];
        if (!in_array($sort, $allowedSorts)) $sort = 'created_at';
        if (!in_array($direction, ['asc', 'desc'])) $direction = 'desc';

        $customers = $query->orderBy($sort, $direction)->paginate(20)->appends($request->except('page'));

        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $user)
    {
        $user->load(['vehicles', 'appointments' => function($q) {
            $q->orderBy('appointment_date', 'desc');
        }]);

        return view('admin.customers.show', compact('user'));
    }
}

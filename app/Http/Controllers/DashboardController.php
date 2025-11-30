<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index(Request $request): Response
    {
        $doctorFilter = $request->query('doctor');

        // Get pending appointments
        $pendingQuery = Appointment::with('doctor')
            ->where('status', 'pending')
            ->orderBy('start_time', 'asc');

        if ($doctorFilter) {
            $pendingQuery->where('doctor_id', $doctorFilter);
        }

        $pendingAppointments = $pendingQuery->limit(10)->get();

        // Get upcoming confirmed appointments
        $upcomingQuery = Appointment::with('doctor')
            ->where('status', 'confirmed')
            ->where('start_time', '>=', now())
            ->orderBy('start_time', 'asc');

        if ($doctorFilter) {
            $upcomingQuery->where('doctor_id', $doctorFilter);
        }

        $upcomingAppointments = $upcomingQuery->limit(10)->get();

        // Statistics
        $stats = [
            'pending' => Appointment::when($doctorFilter, fn($q) => $q->where('doctor_id', $doctorFilter))->where('status', 'pending')->count(),
            'confirmed' => Appointment::when($doctorFilter, fn($q) => $q->where('doctor_id', $doctorFilter))->where('status', 'confirmed')->where('start_time', '>=', now())->count(),
            'completed_today' => Appointment::when($doctorFilter, fn($q) => $q->where('doctor_id', $doctorFilter))->where('status', 'completed')->whereDate('start_time', today())->count(),
        ];

        $doctors = Doctor::all();

        return Inertia::render('Dashboard/Index', [
            'pendingAppointments' => $pendingAppointments,
            'upcomingAppointments' => $upcomingAppointments,
            'stats' => $stats,
            'doctors' => $doctors,
            'selectedDoctor' => $doctorFilter,
        ]);
    }
}

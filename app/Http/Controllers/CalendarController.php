<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Services\AppointmentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CalendarController extends Controller
{
    /**
     * Display the calendar.
     */
    public function index(Request $request): Response
    {
        $request->validate([
            'doctor' => 'required|exists:doctors,slug',
        ]);

        $doctorSlug = $request->query('doctor');
        $weekStart = $request->query('week') 
            ? Carbon::parse($request->query('week'))->startOfWeek() 
            : Carbon::now()->startOfWeek();

        $weekEnd = $weekStart->copy()->endOfWeek();

        $doctor = Doctor::where('slug', $doctorSlug)->firstOrFail();
        
        // Get appointments for the week
        $appointments = Appointment::with('doctor')
            ->where('doctor_id', $doctor->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->whereBetween('start_time', [$weekStart, $weekEnd])
            ->orderBy('start_time', 'asc')
            ->get();

        // Get available slots
        $appointmentService = app(AppointmentService::class);
        $availableSlots = $appointmentService->getAvailableSlots($doctor->id, $weekStart);

        $doctors = Doctor::all();

        return Inertia::render('Calendar/Index', [
            'doctors' => $doctors,
            'selectedDoctor' => $doctor,
            'appointments' => $appointments,
            'availableSlots' => $availableSlots,
            'weekStart' => $weekStart->format('Y-m-d'),
            'weekEnd' => $weekEnd->format('Y-m-d'),
        ]);
    }
}

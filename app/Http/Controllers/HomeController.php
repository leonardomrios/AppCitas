<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Services\AppointmentService;
use Carbon\Carbon;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        $doctors = Doctor::all();
        $selectedDoctor = request('doctor');
        $weekStart = request('week') 
            ? Carbon::parse(request('week'))->startOfWeek() 
            : Carbon::now()->startOfWeek();

        $availableSlots = collect();
        
        if ($selectedDoctor) {
            $doctor = Doctor::where('slug', $selectedDoctor)->first();
            if ($doctor) {
                $appointmentService = app(AppointmentService::class);
                $availableSlots = $appointmentService->getAvailableSlots($doctor->id, $weekStart);
            }
        }

        return Inertia::render('Home', [
            'doctors' => $doctors,
            'selectedDoctor' => $selectedDoctor,
            'weekStart' => $weekStart->format('Y-m-d'),
            'availableSlots' => $availableSlots,
        ]);
    }
}

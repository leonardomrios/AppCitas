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
        
        // Si no se especifica una semana, comenzar con la semana actual
        if (request('week')) {
            $weekStart = Carbon::parse(request('week'))->startOfWeek();
        } else {
            // Si estamos en fin de semana o después del viernes a las 19:00, mostrar la próxima semana
            $now = Carbon::now();
            $isDayOfWeek = $now->dayOfWeek;
            
            // Domingo = 0, Sábado = 6, Viernes = 5
            if ($isDayOfWeek === Carbon::SUNDAY || 
                $isDayOfWeek === Carbon::SATURDAY || 
                ($isDayOfWeek === Carbon::FRIDAY && $now->hour >= 19)) {
                // Mostrar la próxima semana laboral (próximo lunes)
                $weekStart = $now->next(Carbon::MONDAY)->startOfWeek();
            } else {
                $weekStart = $now->startOfWeek();
            }
        }

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

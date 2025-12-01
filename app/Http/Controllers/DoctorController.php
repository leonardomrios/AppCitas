<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Services\AppointmentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource (public).
     */
    public function index(): Response
    {
        $doctors = Doctor::all();

        return Inertia::render('Doctors/Index', [
            'doctors' => $doctors,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Doctors/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email',
            'phone' => 'nullable|string|max:20',
            'specialty' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
        ]);

        // El slug se genera automáticamente en el modelo (HasSlug trait)
        $doctor = Doctor::create($validated);

        // Crear horarios de disponibilidad por defecto (Lunes a Viernes, 9:00-13:00 y 15:00-19:00)
        $this->createDefaultAvailability($doctor);

        return redirect()->route('doctors.index')
            ->with('success', 'Médico creado exitosamente.');
    }

    /**
     * Display the specified resource (public by slug).
     */
    public function show(Doctor $doctor): Response
    {
        $appointmentService = app(AppointmentService::class);
        $weekStart = Carbon::now()->startOfWeek();
        $availableSlots = $appointmentService->getAvailableSlots($doctor->id, $weekStart);

        // Get next 10 available slots
        $nextSlots = $availableSlots->take(10)->values();

        return Inertia::render('Doctors/Show', [
            'doctor' => $doctor,
            'nextSlots' => $nextSlots,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor): Response
    {
        return Inertia::render('Doctors/Edit', [
            'doctor' => $doctor,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email,' . $doctor->id,
            'phone' => 'nullable|string|max:20',
            'specialty' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $doctor->update($validated);

        return redirect()->route('doctors.index')
            ->with('success', 'Médico actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        // Verificar si el doctor tiene citas relacionadas
        $appointmentsCount = $doctor->appointments()->count();
        
        if ($appointmentsCount > 0) {
            return redirect()->route('doctors.index')
                ->withErrors([
                    'delete' => "No se puede eliminar al doctor {$doctor->name} porque tiene {$appointmentsCount} cita(s) asignada(s). 
                    Primero debe eliminar o reasignar todas las citas del doctor."
                ]);
        }

        // Si no tiene citas, proceder con la eliminación
        $doctorName = $doctor->name;
        $doctor->delete();

        return redirect()->route('doctors.index')
            ->with('success', "Médico {$doctorName} eliminado exitosamente.");
    }

    /**
     * Create default availability schedule for a doctor.
     * Monday to Friday: 9:00 AM - 1:00 PM and 3:00 PM - 7:00 PM
     */
    private function createDefaultAvailability(Doctor $doctor): void
    {
        $schedules = [
            ['start' => '09:00:00', 'end' => '13:00:00'],
            ['start' => '15:00:00', 'end' => '19:00:00'],
        ];

        // Create availability for Monday (1) to Friday (5)
        for ($day = 1; $day <= 5; $day++) {
            foreach ($schedules as $schedule) {
                $doctor->availabilities()->create([
                    'day_of_week' => $day,
                    'start_time' => $schedule['start'],
                    'end_time' => $schedule['end'],
                ]);
            }
        }
    }
}

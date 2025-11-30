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

        $doctor = Doctor::create($validated);

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
        $doctor->delete();

        return redirect()->route('doctors.index')
            ->with('success', 'Médico eliminado exitosamente.');
    }
}

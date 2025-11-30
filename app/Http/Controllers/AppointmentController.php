<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppointmentRequest;
use App\Mail\AppointmentAccepted;
use App\Mail\AppointmentCreated;
use App\Mail\AppointmentRejected;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Services\AppointmentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;

class AppointmentController extends Controller
{
    protected AppointmentService $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    /**
     * Display a listing of the resource (admin).
     */
    public function index(Request $request): Response
    {
        $query = Appointment::with('doctor')
            ->orderBy('start_time', 'desc');

        // Filter by doctor
        if ($request->filled('doctor')) {
            $query->where('doctor_id', $request->doctor);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $appointments = $query->paginate(15)->withQueryString();
        $doctors = Doctor::all();

        return Inertia::render('Appointments/Index', [
            'appointments' => $appointments,
            'doctors' => $doctors,
            'filters' => $request->only(['doctor', 'status']),
        ]);
    }

    /**
     * Show the form for creating a new resource (public).
     */
    public function create(Request $request): Response
    {
        $doctorSlug = $request->query('doctor');
        $startTime = $request->query('start');

        \Log::info('DEBUG Create Form', [
            'doctor_slug' => $doctorSlug,
            'start_time_raw' => $startTime,
            'user_agent' => $request->header('User-Agent'),
        ]);

        $doctor = null;
        $slotDate = null;
        $slotTime = null;

        if ($doctorSlug && $startTime) {
            $doctor = Doctor::where('slug', $doctorSlug)->first();
            if ($doctor && $startTime) {
                $dateTime = Carbon::parse($startTime);
                $slotDate = $dateTime->format('Y-m-d');
                $slotTime = $dateTime->format('H:i');
                
                \Log::info('DEBUG Parsed DateTime', [
                    'parsed' => $dateTime->format('Y-m-d H:i:s'),
                    'timezone' => $dateTime->timezone->getName(),
                ]);
            }
        }

        return Inertia::render('Appointments/Create', [
            'doctor' => $doctor,
            'slotDate' => $slotDate,
            'slotTime' => $slotTime,
            'startTime' => $startTime,
        ]);
    }

    /**
     * Store a newly created resource in storage (public).
     */
    public function store(AppointmentRequest $request)
    {
        $validated = $request->validated();

        $startTime = Carbon::parse($validated['start_time']);
        $duration = config('appointment.duration_minutes');
        $endTime = Carbon::parse($request->start_time)->addMinutes($duration);

        $appointment = Appointment::create([
            'doctor_id' => $validated['doctor_id'],
            'patient_name' => $validated['patient_name'],
            'patient_email' => $validated['patient_email'],
            'patient_phone' => $validated['patient_phone'],
            'reason' => $validated['reason'],
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => 'pending',
        ]);

        // Send email notification
        Mail::to($validated['patient_email'])->send(new AppointmentCreated($appointment));

        return redirect()->route('welcome')
            ->with('success', 'Tu solicitud de cita ha sido enviada. Te notificaremos por correo cuando sea procesada.');
    }

    /**
     * Display the specified resource (admin).
     */
    public function show(Appointment $appointment): Response
    {
        $appointment->load('doctor');

        return Inertia::render('Appointments/Show', [
            'appointment' => $appointment,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment): Response
    {
        $appointment->load('doctor');
        $doctors = Doctor::all();

        return Inertia::render('Appointments/Edit', [
            'appointment' => $appointment,
            'doctors' => $doctors,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'patient_name' => 'required|string|max:255',
            'patient_email' => 'required|email|max:255',
            'patient_phone' => 'required|string|max:20',
            'reason' => 'required|string|max:1000',
            'start_time' => 'required|date',
            'status' => 'required|in:pending,confirmed,completed,rejected',
        ]);

        $startTime = Carbon::parse($validated['start_time']);
        $endTime = $this->appointmentService->calculateEndTime($startTime);

        $appointment->update([
            ...$validated,
            'end_time' => $endTime,
        ]);

        return redirect()->route('appointments.index')
            ->with('success', 'Cita actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('appointments.index')
            ->with('success', 'Cita eliminada exitosamente.');
    }

    /**
     * Accept an appointment.
     */
    public function accept(Appointment $appointment)
    {
        if (!$appointment->canBeAccepted()) {
            return back()->withErrors(['error' => 'Esta cita no puede ser aceptada.']);
        }

        $appointment->update(['status' => 'confirmed']);

        // Send email notification
        Mail::to($appointment->patient_email)->send(new AppointmentAccepted($appointment));

        return redirect()->route('appointments.index')
            ->with('success', 'Cita aceptada y notificación enviada.');
    }

    /**
     * Reject an appointment.
     */
    public function reject(Appointment $appointment)
    {
        if (!$appointment->canBeRejected()) {
            return back()->withErrors(['error' => 'Esta cita no puede ser rechazada.']);
        }

        $appointment->update(['status' => 'rejected']);

        // Send email notification
        Mail::to($appointment->patient_email)->send(new AppointmentRejected($appointment));

        return redirect()->route('appointments.index')
            ->with('success', 'Cita rechazada y notificación enviada.');
    }

    /**
     * Complete an appointment.
     */
    public function complete(Appointment $appointment)
    {
        if (!$appointment->canBeCompleted()) {
            return back()->withErrors(['error' => 'Solo las citas confirmadas pueden ser completadas.']);
        }

        $appointment->update(['status' => 'completed']);

        return redirect()->route('appointments.index')
            ->with('success', 'Cita marcada como completada.');
    }

    /**
     * Cancel an appointment.
     */
    public function cancel(Appointment $appointment)
    {
        if (!$appointment->canBeCancelled()) {
            return back()->withErrors(['error' => 'Esta cita no puede ser cancelada.']);
        }

        $appointment->update(['status' => 'rejected']);

        return redirect()->route('appointments.index')
            ->with('success', 'Cita cancelada exitosamente.');
    }
}

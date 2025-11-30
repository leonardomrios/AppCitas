<?php

namespace App\Http\Requests;

use App\Models\Doctor;
use App\Services\AppointmentService;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Public route
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'doctor_id' => ['required', 'exists:doctors,id'],
            'patient_name' => ['required', 'string', 'max:255'],
            'patient_email' => ['required', 'email', 'max:255'],
            'patient_phone' => ['required', 'string', 'max:20'],
            'reason' => ['required', 'string', 'max:1000'],
            'start_time' => [
                'required',
                'date',
                'after:now',
                function ($attribute, $value, $fail) {
                    $doctorId = $this->input('doctor_id');
                    $startTime = Carbon::parse($value);
                    $appointmentService = app(AppointmentService::class);
                    $endTime = $appointmentService->calculateEndTime($startTime);

                    // Debug: Log para verificar qué está llegando
                    \Log::info('DEBUG Appointment Validation', [
                        'raw_value' => $value,
                        'parsed_start' => $startTime->format('Y-m-d H:i:s'),
                        'parsed_end' => $endTime->format('Y-m-d H:i:s'),
                        'doctor_id' => $doctorId,
                        'is_available' => $appointmentService->checkAvailability($doctorId, $startTime, $endTime),
                        'timezone' => $startTime->timezone->getName(),
                    ]);

                    if (!$appointmentService->checkAvailability($doctorId, $startTime, $endTime)) {
                        $fail('El horario seleccionado no está disponible.');
                    }
                },
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'doctor_id.required' => 'Debe seleccionar un médico.',
            'doctor_id.exists' => 'El médico seleccionado no existe.',
            'patient_name.required' => 'El nombre es requerido.',
            'patient_email.required' => 'El correo electrónico es requerido.',
            'patient_email.email' => 'Debe proporcionar un correo electrónico válido.',
            'patient_phone.required' => 'El teléfono es requerido.',
            'reason.required' => 'Debe proporcionar el motivo de la consulta.',
            'start_time.required' => 'Debe seleccionar una fecha y hora.',
            'start_time.after' => 'La fecha y hora deben ser en el futuro.',
        ];
    }
}

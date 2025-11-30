<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cita Confirmada</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2 style="color: #10b981;">Tu Cita Médica ha sido Confirmada</h2>
        
        <p>Estimado/a {{ $appointment->patient_name }},</p>
        
        <p>Nos complace informarte que tu cita médica ha sido <strong>confirmada</strong>.</p>
        
        <div style="background-color: #d1fae5; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <p><strong>Médico:</strong> {{ $doctor->name }}</p>
            <p><strong>Especialidad:</strong> {{ $doctor->specialty }}</p>
            <p><strong>Fecha y Hora:</strong> {{ $appointment->start_time->format('d/m/Y H:i') }}</p>
            <p><strong>Duración:</strong> {{ config('appointment.duration_minutes', 30) }} minutos</p>
            <p><strong>Motivo:</strong> {{ $appointment->reason }}</p>
        </div>
        
        <p>Por favor, asegúrate de llegar con 10 minutos de anticipación.</p>
        
        <p>Saludos cordiales,<br>Clínica de Gastroenterología</p>
    </div>
</body>
</html>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Solicitud de Cita Recibida</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2 style="color: #2563eb;">Solicitud de Cita Médica Recibida</h2>
        
        <p>Estimado/a {{ $appointment->patient_name }},</p>
        
        <p>Hemos recibido tu solicitud de cita médica. Los detalles son los siguientes:</p>
        
        <div style="background-color: #f3f4f6; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <p><strong>Médico:</strong> {{ $doctor->name }}</p>
            <p><strong>Especialidad:</strong> {{ $doctor->specialty }}</p>
            <p><strong>Fecha y Hora:</strong> {{ $appointment->start_time->format('d/m/Y H:i') }}</p>
            <p><strong>Motivo:</strong> {{ $appointment->reason }}</p>
        </div>
        
        <p>Tu solicitud está en estado <strong>Pendiente</strong>. Te notificaremos por correo cuando sea procesada.</p>
        
        <p>Saludos cordiales,<br>Clínica de Gastroenterología</p>
    </div>
</body>
</html>


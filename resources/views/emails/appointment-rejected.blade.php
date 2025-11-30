<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Actualización sobre tu Cita</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2 style="color: #ef4444;">Actualización sobre tu Solicitud de Cita</h2>
        
        <p>Estimado/a {{ $appointment->patient_name }},</p>
        
        <p>Lamentamos informarte que tu solicitud de cita médica no pudo ser confirmada en el horario solicitado.</p>
        
        <div style="background-color: #fee2e2; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <p><strong>Médico:</strong> {{ $doctor->name }}</p>
            <p><strong>Fecha y Hora Solicitada:</strong> {{ $appointment->start_time->format('d/m/Y H:i') }}</p>
            <p><strong>Motivo:</strong> {{ $appointment->reason }}</p>
        </div>
        
        <p>Te invitamos a agendar una nueva cita en nuestro sistema con otro horario disponible.</p>
        
        <p>Si tienes alguna pregunta, no dudes en contactarnos.</p>
        
        <p>Saludos cordiales,<br>Clínica de Gastroenterología</p>
    </div>
</body>
</html>


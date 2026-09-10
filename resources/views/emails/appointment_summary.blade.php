<!doctype html>
<html lang="es">
<head><meta charset="utf-8"><title>Resumen de consulta</title></head>
<body style="font-family:Arial,sans-serif;color:#263238;line-height:1.5">
    <h2>{{ AppSetting('title') }} - Resumen de consulta</h2>
    <p>Paciente: <strong>{{ optional($appointment->patient)->first_name }} {{ optional($appointment->patient)->last_name }}</strong></p>
    <p>Fecha de la cita: <strong>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}</strong></p>
    <h3>Diagnóstico</h3>
    @if (!empty($appointment->dentalEvaluation->diagnosis_items))
        <table cellpadding="8" cellspacing="0" border="1" style="border-collapse:collapse;width:100%">
            <thead><tr><th>Diagnóstico</th><th>Tratamiento</th><th>Cantidad</th><th>Valor unitario</th><th>Subtotal</th></tr></thead>
            <tbody>
            @foreach ($appointment->dentalEvaluation->diagnosis_items as $item)
                <tr><td>{{ $item['diagnosis'] ?? '' }}</td><td>{{ $item['treatment'] ?? '' }}</td><td>{{ $item['quantity'] ?? 0 }}</td><td>{{ number_format((float) ($item['value'] ?? 0), 2) }}</td><td>{{ number_format((float) ($item['subtotal'] ?? 0), 2) }}</td></tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>{{ $appointment->dentalEvaluation->diagnosis ?: 'Sin diagnóstico registrado.' }}</p>
    @endif
    <p><strong>Total de la consulta: {{ number_format((float) ($appointment->final_consultation_price ?? 0), 2) }}</strong></p>
    <p>Notas clínicas: {{ $appointment->dentalEvaluation->clinical_notes ?: 'Sin notas adicionales.' }}</p>
</body>
</html>
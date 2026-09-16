<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Resumen de consulta</title>
</head>
<body style="margin:0;padding:0;background:#f4f7fb;font-family:Arial,Helvetica,sans-serif;color:#1f2937;">
    <div style="max-width:760px;margin:0 auto;background:#ffffff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">
        <div style="background:linear-gradient(135deg,#0f766e,#0ea5a4);padding:28px 32px;color:#ffffff;">
            <div style="font-size:13px;letter-spacing:1px;text-transform:uppercase;opacity:0.9;"><?php echo e(AppSetting('title')); ?></div>
            <h2 style="margin:8px 0 0 0;font-size:28px;line-height:1.2;">Resumen de consulta</h2>
        </div>

        <div style="padding:28px 32px 18px;">
            <p style="margin:0 0 12px 0;font-size:14px;color:#374151;">
                <strong>Paciente:</strong> <?php echo e(optional($appointment->patient)->first_name); ?> <?php echo e(optional($appointment->patient)->last_name); ?>

            </p>
            <p style="margin:0 0 12px 0;font-size:14px;color:#374151;">
                <strong>Cédula:</strong> <?php echo e(optional($appointment->patient)->cedula ?: 'No registrada'); ?>

            </p>
            <p style="margin:0 0 12px 0;font-size:14px;color:#374151;">
                <strong>Doctor que lo atendió:</strong> <?php echo e(optional(optional($appointment->doctor)->user)->first_name); ?> <?php echo e(optional(optional($appointment->doctor)->user)->last_name); ?>

            </p>
            <p style="margin:0 0 12px 0;font-size:14px;color:#374151;">
                <strong>Especialidad:</strong> <?php echo e(optional($appointment->doctor)->title ?: 'No registrada'); ?>

            </p>
            <p style="margin:0 0 20px 0;font-size:14px;color:#374151;">
                <strong>Fecha de la cita:</strong> <?php echo e(\Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y')); ?>

            </p>

            <h3 style="margin:0 0 12px 0;font-size:22px;color:#111827;">Diagnóstico y tratamiento realizado</h3>

            <?php if(!empty($appointment->dentalEvaluation->diagnosis_items)): ?>
                <table cellpadding="8" cellspacing="0" border="1" style="border-collapse:collapse;width:100%;font-size:13px;color:#1f2937;border-color:#dfe3ea;">
                    <thead>
                        <tr>
                            <th style="background:#f3f4f6;text-align:left;padding:10px;">Diagnóstico</th>
                            <th style="background:#f3f4f6;text-align:left;padding:10px;">Tratamiento</th>
                            <th style="background:#f3f4f6;text-align:left;padding:10px;">Cantidad</th>
                            <th style="background:#f3f4f6;text-align:left;padding:10px;">Valor unitario</th>
                            <th style="background:#f3f4f6;text-align:left;padding:10px;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $appointment->dentalEvaluation->diagnosis_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td style="padding:10px;"><?php echo e($item['diagnosis'] ?? ''); ?></td>
                            <td style="padding:10px;"><?php echo e($item['treatment'] ?? ''); ?></td>
                            <td style="padding:10px;"><?php echo e($item['quantity'] ?? 0); ?></td>
                            <td style="padding:10px;">$<?php echo e(number_format((float) ($item['value'] ?? 0), 2)); ?></td>
                            <td style="padding:10px;">$<?php echo e(number_format((float) ($item['subtotal'] ?? 0), 2)); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p style="margin:0 0 18px 0;color:#374151;"><?php echo e($appointment->dentalEvaluation->diagnosis ?: 'Sin diagnóstico registrado.'); ?></p>
            <?php endif; ?>

            <p style="margin:18px 0 8px 0;font-size:14px;color:#374151;">
                <strong>Notas clínicas:</strong> <?php echo e($appointment->dentalEvaluation->clinical_notes ?: 'Sin notas adicionales.'); ?>

            </p>

            <div style="margin-top:20px;border-top:1px solid #e5e7eb;padding-top:18px;">
                <p style="margin:0;text-align:right;font-size:22px;font-weight:bold;color:#111827;">
                    Total final de la consulta: $<?php echo e(number_format((float) ($appointment->final_consultation_price ?? 0), 2)); ?>

                </p>
            </div>
        </div>

        <div style="background:#f8fafc;border-top:1px solid #e5e7eb;padding:18px 32px;color:#475569;font-size:13px;">
            Gracias por confiar en <?php echo e(AppSetting('title')); ?>.<br>
            Estamos para cuidarte y ayudarte a mantener tu salud dental.
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views\emails\appointment_summary.blade.php ENDPATH**/ ?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Presupuesto final</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            background: #f5f7fb;
            color: #1f2937;
        }
        .page {
            width: 780px;
            margin: 30px auto;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 18px rgba(0,0,0,0.05);
        }
        .topbar {
            background: linear-gradient(135deg, #0f766e, #14b8a6);
            color: #fff;
            padding: 28px 32px;
        }
        .brand {
            font-size: 12px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            opacity: 0.9;
        }
        .title {
            margin: 8px 0 0;
            font-size: 30px;
            font-weight: bold;
        }
        .content {
            padding: 28px 32px 18px;
        }
        .meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px 18px;
            margin-bottom: 24px;
            font-size: 14px;
            color: #374151;
        }
        .meta strong {
            color: #111827;
        }
        h3 {
            margin: 0 0 14px;
            font-size: 22px;
            color: #111827;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 13px;
        }
        th, td {
            border: 1px solid #dfe3ea;
            padding: 10px 8px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background: #f3f4f6;
            color: #111827;
            font-weight: bold;
        }
        .total-box {
            margin-top: 22px;
            padding-top: 18px;
            border-top: 1px solid #e5e7eb;
            text-align: right;
            font-size: 22px;
            font-weight: bold;
            color: #111827;
        }
        .footer {
            background: #f8fafc;
            border-top: 1px solid #e5e7eb;
            padding: 18px 32px;
            font-size: 13px;
            color: #475569;
        }
        .actions {
            margin-top: 20px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        .actions a {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 6px;
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            background: #0d6efd;
        }
        .actions a.secondary {
            background: #25D366;
        }
        @media print {
            body {
                background: #fff;
            }
            .page {
                box-shadow: none;
                border: none;
                margin: 0;
                width: 100%;
            }
            .actions {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="topbar">
            <div class="brand"><?php echo e(AppSetting('title') ?? 'Clínica'); ?></div>
            <div class="title">Presupuesto final</div>
        </div>

        <div class="content">
            <div class="meta">
                <div><strong>Paciente:</strong> <?php echo e(optional($appointment->patient)->first_name); ?> <?php echo e(optional($appointment->patient)->last_name); ?></div>
                <div><strong>Cédula:</strong> <?php echo e(optional($appointment->patient)->cedula ?: 'No registrada'); ?></div>
                <div><strong>Doctor:</strong> <?php echo e(optional(optional($appointment->doctor)->user)->first_name); ?> <?php echo e(optional(optional($appointment->doctor)->user)->last_name); ?></div>
                <div><strong>Especialidad:</strong> <?php echo e(optional($appointment->doctor)->title ?: 'No registrada'); ?></div>
                <div><strong>Fecha:</strong> <?php echo e($appointment->appointment_date); ?></div>
                <div><strong>Cita:</strong> #<?php echo e($appointment->id); ?></div>
            </div>

            <h3>Detalle de servicios y diagnóstico</h3>

            <?php if(!empty($items)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Diagnóstico</th>
                            <th>Tratamiento</th>
                            <th>Cantidad</th>
                            <th>Valor unitario</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($item['diagnosis'] ?? 'Diagnóstico'); ?></td>
                                <td><?php echo e($item['treatment'] ?? '-'); ?></td>
                                <td><?php echo e(number_format((float) ($item['quantity'] ?? 1), 2, '.', ',')); ?></td>
                                <td>$ <?php echo e(number_format((float) ($item['value'] ?? 0), 2, '.', ',')); ?></td>
                                <td>$ <?php echo e(number_format((float) ($item['subtotal'] ?? (($item['quantity'] ?? 1) * ($item['value'] ?? 0))), 2, '.', ',')); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No hay diagnósticos registrados para esta cita.</p>
            <?php endif; ?>

            <div class="total-box">Total final: $ <?php echo e(number_format((float) $total, 2, '.', ',')); ?></div>

            <div class="actions">
                <a href="javascript:window.print();">Descargar / Imprimir</a>
                <a class="secondary" href="<?php echo e(route('appointment.budget.whatsapp', $appointment->id)); ?>" target="_blank" rel="noopener">Enviar por WhatsApp</a>
            </div>
        </div>

        <div class="footer">
            Gracias por confiar en <?php echo e(AppSetting('title')); ?>.<br>
            Estamos para cuidarte y ayudarte a mantener tu salud dental.
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views\appointment\appointment-budget.blade.php ENDPATH**/ ?>
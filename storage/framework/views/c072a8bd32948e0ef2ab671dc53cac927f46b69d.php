

<?php $__env->startSection('title'); ?>
    <?php echo e('Reporte mensual de pago a doctores'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('title'); ?>
            <?php echo e('Reportes'); ?>

        <?php $__env->endSlot(); ?>
        <?php $__env->slot('li_1'); ?>
            <?php echo e('Finanzas'); ?>

        <?php $__env->endSlot(); ?>
        <?php $__env->slot('li_2'); ?>
            <?php echo e('Pago mensual a doctores'); ?>

        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="<?php echo e(url('doctor-monthly-payout-report')); ?>" class="row g-3 align-items-end mb-4">
                        <div class="col-md-3">
                            <label for="month" class="form-label"><?php echo e('Mes'); ?></label>
                            <select id="month" name="month" class="form-select">
                                <?php for($m = 1; $m <= 12; $m++): ?>
                                    <option value="<?php echo e($m); ?>" <?php echo e((int) $selectedMonth === $m ? 'selected' : ''); ?>>
                                        <?php echo e(\Carbon\Carbon::create()->month($m)->translatedFormat('F')); ?>

                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="year" class="form-label"><?php echo e('Año'); ?></label>
                            <input type="number" min="2000" max="2100" id="year" name="year" class="form-control"
                                value="<?php echo e($selectedYear); ?>">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary"><?php echo e('Filtrar'); ?></button>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle mb-0">
                            <thead>
                                <tr>
                                    <th><?php echo e('Doctor'); ?></th>
                                    <th><?php echo e('Pacientes atendidos'); ?></th>
                                    <th><?php echo e('Citas completadas'); ?></th>
                                    <th><?php echo e('Total servicios'); ?></th>
                                    <th><?php echo e('Precio final consulta'); ?></th>
                                    <th><?php echo e('% Doctor'); ?></th>
                                    <th><?php echo e('Total a pagar'); ?></th>
                                    <th><?php echo e('Pendiente'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_2 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                    <tr>
                                        <td><?php echo e($item->doctor_name); ?></td>
                                        <td><?php echo e(number_format((int) $item->attended_patients)); ?></td>
                                        <td><?php echo e(number_format((int) $item->completed_appointments)); ?></td>
                                        <td>$<?php echo e(number_format((float) $item->total_services_amount, 2)); ?></td>
                                        <td>$<?php echo e(number_format((float) $item->total_final_consultation_price, 2)); ?></td>
                                        <td><?php echo e(number_format((float) $item->doctor_payment_percentage, 2)); ?>%</td>
                                        <td>$<?php echo e(number_format((float) $item->doctor_payable_amount, 2)); ?></td>
                                        <td>$<?php echo e(number_format((float) $item->pending_payment_amount, 2)); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                    <tr>
                                        <td colspan="8" class="text-center"><?php echo e('No hay resultados para el periodo seleccionado.'); ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th><?php echo e('Total'); ?></th>
                                    <th><?php echo e(number_format((int) $totals['attended_patients'])); ?></th>
                                    <th><?php echo e(number_format((int) $totals['completed_appointments'])); ?></th>
                                    <th>$<?php echo e(number_format((float) $totals['total_services_amount'], 2)); ?></th>
                                    <th>$<?php echo e(number_format((float) $totals['total_final_consultation_price'], 2)); ?></th>
                                    <th>-</th>
                                    <th>$<?php echo e(number_format((float) $totals['doctor_payable_amount'], 2)); ?></th>
                                    <th>$<?php echo e(number_format((float) $totals['pending_payment_amount'], 2)); ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views\reports\doctor-monthly-payout.blade.php ENDPATH**/ ?>
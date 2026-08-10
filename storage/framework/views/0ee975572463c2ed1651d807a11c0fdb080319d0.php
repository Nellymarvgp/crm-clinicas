
<?php $__env->startSection('title'); ?> <?php echo e(__('Detalle de Cita')); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('title'); ?> Detalle de Cita <?php $__env->endSlot(); ?>
        <?php $__env->slot('li_1'); ?> Panel <?php $__env->endSlot(); ?>
        <?php $__env->slot('li_2'); ?> Citas <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row mb-3">
        <div class="col-12">
            <a href="<?php echo e(url()->previous()); ?>" class="btn btn-primary">
                <i class="mdi mdi-arrow-left me-1"></i><?php echo e(__('Volver')); ?>

            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4"><?php echo e(__('Información de la Cita')); ?></h4>
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <tbody>
                                <tr>
                                    <th style="width: 280px;"><?php echo e(__('ID de Cita')); ?></th>
                                    <td><?php echo e($appointment->id); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo e(__('Paciente')); ?></th>
                                    <td><?php echo e(optional($appointment->patient)->first_name); ?> <?php echo e(optional($appointment->patient)->last_name); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo e(__('Odontólogo')); ?></th>
                                    <td><?php echo e(optional(optional($appointment->doctor)->user)->first_name); ?> <?php echo e(optional(optional($appointment->doctor)->user)->last_name); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo e(__('Fecha')); ?></th>
                                    <td><?php echo e($appointment->appointment_date); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo e(__('Hora')); ?></th>
                                    <td>
                                        <?php if(optional($appointment->timeSlot)->from): ?>
                                            <?php echo e(\Carbon\Carbon::parse(optional($appointment->timeSlot)->from)->format('H:i')); ?> a <?php echo e(\Carbon\Carbon::parse(optional($appointment->timeSlot)->to)->format('H:i')); ?>

                                        <?php else: ?>
                                            <?php echo e(__('Sin horario')); ?>

                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo e(__('Estado')); ?></th>
                                    <td>
                                        <?php if((int) $appointment->status === 1): ?>
                                            <span class="badge badge-pill text-white" style="background-color:#198754;"><?php echo e(__('Completada')); ?></span>
                                        <?php elseif((int) $appointment->status === 2): ?>
                                            <span class="badge badge-pill text-white" style="background-color:#dc3545;"><?php echo e(__('Cancelada')); ?></span>
                                        <?php else: ?>
                                            <span class="badge badge-pill text-white" style="background-color:#0dcaf0;"><?php echo e(__('Pendiente')); ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo e(__('Monto Final')); ?></th>
                                    <td>
                                        <?php if(!is_null($appointment->final_consultation_price)): ?>
                                            $<?php echo e(number_format((float) $appointment->final_consultation_price, 2, '.', ',')); ?>

                                        <?php else: ?>
                                            <?php echo e(__('No definido')); ?>

                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo e(__('Creada por')); ?></th>
                                    <td><?php echo e(optional($appointment->BookedBy)->first_name); ?> <?php echo e(optional($appointment->BookedBy)->last_name); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views/appointment/appointment-view.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title'); ?> <?php echo e(__('Agendar Cita')); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <!-- Calender -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(URL::asset('build/libs/fullcalendar/fullcalendar.min.css')); ?>">
<?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <!-- start page title -->
        <?php $__env->startComponent('components.breadcrumb'); ?>
            <?php $__env->slot('title'); ?> Agendar Cita <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_1'); ?> Panel <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_2'); ?> Citas <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <a href="<?php echo e(url('/pending-appointment')); ?>"
                    class="btn btn-outline-primary waves-effect waves-light mb-4 me-2">
                    <i class="bx bx-list-ul font-size-16 align-middle me-2"></i> <?php echo e(__('Ver Citas')); ?>

                </a>
                <a href="<?php echo e(url('/appointment-create')); ?>"
                    class="btn btn-primary text-white waves-effect waves-light mb-4">
                    <i class="bx bx-plus font-size-16 align-middle me-2"></i> <?php echo e(__('Nueva Cita')); ?>

                </a>
            </div> <!-- end col -->
        </div> <!-- end row -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div id='calendar'></div>
                    </div>
                </div>
            </div> <!-- end col -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4"><?php echo e(__('Lista de Citas')); ?> | <label
                            id="selected_date"><?php echo e(\Carbon\Carbon::now()->locale('es')->translatedFormat('d/m/Y')); ?></label>
                        </h4>
                        <div id="appointment_list">
                            <table class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="thead-light">
                                    <tr>
                                        <th><?php echo e(__('Nro.')); ?></th>
                                        <?php if($role == 'patient'): ?>
                                            <th><?php echo e(__('Nombre del Odontólogo')); ?></th>
                                            <th><?php echo e(__('Número del Odontólogo')); ?></th>
                                        <?php elseif($role == 'doctor'): ?>
                                            <th><?php echo e(__('Nombre del Paciente')); ?></th>
                                            <th><?php echo e(__('Número del Paciente')); ?></th>
                                        <?php else: ?>
                                            <th><?php echo e(__('Nombre del Paciente')); ?></th>
                                            <th><?php echo e(__('Nombre del Odontólogo')); ?></th>
                                            <th><?php echo e(__('Número del Paciente')); ?></th>

                                        <?php endif; ?>
                                        <th><?php echo e(__('Hora')); ?></th>
                                        <th><?php echo e(__('Estado')); ?></th>
                                        <?php if($role == 'admin' || $role == 'doctor' || $role == 'receptionist'): ?>
                                            <th><?php echo e(__('Acción')); ?></th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i = 1;
                                    ?>
                                    <?php if($role == 'receptionist'): ?>
                                        <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td> <?php echo e($i); ?> </td>
                                                <td><?php echo e($appointment->patient->first_name . ' ' . $appointment->patient->last_name); ?>

                                                </td>
                                                <td><?php echo e(@$appointment->doctor->user->first_name . ' ' . @$appointment->doctor->user->last_name); ?>

                                                </td>
                                                <td><?php echo e($appointment->patient->mobile); ?></td>
                                                <td>
                                                    <?php echo e(optional($appointment->timeSlot)->from ? \Carbon\Carbon::parse(optional($appointment->timeSlot)->from)->format('H:i') . ' a ' . \Carbon\Carbon::parse(optional($appointment->timeSlot)->to)->format('H:i') : 'Sin horario'); ?>

                                                </td>
                                                <td>
                                                    <?php if($appointment->status == 1): ?>
                                                        <span class="badge badge-pill text-white" style="background-color:#198754;">Completado</span>
                                                    <?php elseif($appointment->status == 2): ?>
                                                        <span class="badge badge-pill text-white" style="background-color:#dc3545;">Cancelado</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-pill text-white" style="background-color:#0dcaf0;">Pendiente</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="<?php echo e(url('appointment-view/' . $appointment->id)); ?>" class="btn btn-primary mb-1"><?php echo e(__('Ver')); ?></a>
                                                    <?php if((int) $appointment->status !== 1): ?>
                                                        <button type="button" class="btn btn-success complete mb-1" data-id="<?php echo e($appointment->id); ?>"><?php echo e(__('Completar')); ?></button>
                                                        <button type="button" class="btn btn-danger cancel mb-1" data-id="<?php echo e($appointment->id); ?>"><?php echo e(__('Cancelar')); ?></button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php
                                                $i++;
                                            ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php elseif($role == 'admin'): ?>
                                        <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td> <?php echo e($i); ?> </td>
                                                <td><?php echo e($appointment->patient->first_name . ' ' . $appointment->patient->last_name); ?>

                                                </td>
                                                <td><?php echo e(@$appointment->doctor->user->first_name . ' ' . @$appointment->doctor->user->last_name); ?>

                                                </td>
                                                <td><?php echo e($appointment->patient->mobile); ?></td>
                                                <td>
                                                    <?php echo e(optional($appointment->timeSlot)->from ? \Carbon\Carbon::parse(optional($appointment->timeSlot)->from)->format('H:i') . ' a ' . \Carbon\Carbon::parse(optional($appointment->timeSlot)->to)->format('H:i') : 'Sin horario'); ?>

                                                </td>
                                                <td>
                                                    <?php if($appointment->status == 1): ?>
                                                        <span class="badge badge-pill text-white" style="background-color:#198754;">Completado</span>
                                                    <?php elseif($appointment->status == 2): ?>
                                                        <span class="badge badge-pill text-white" style="background-color:#dc3545;">Cancelado</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-pill text-white" style="background-color:#0dcaf0;">Pendiente</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="<?php echo e(url('appointment-view/' . $appointment->id)); ?>" class="btn btn-primary mb-1"><?php echo e(__('Ver')); ?></a>
                                                    <?php if((int) $appointment->status !== 1): ?>
                                                        <button type="button" class="btn btn-success complete mb-1" data-id="<?php echo e($appointment->id); ?>"><?php echo e(__('Completar')); ?></button>
                                                        <button type="button" class="btn btn-danger cancel mb-1" data-id="<?php echo e($appointment->id); ?>"><?php echo e(__('Cancelar')); ?></button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php
                                                $i++;
                                            ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php elseif($role == 'doctor'): ?>
                                        <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td> <?php echo e($i); ?> </td>
                                                <td><?php echo e($appointment->patient->first_name . ' ' . $appointment->patient->last_name); ?>

                                                </td>
                                                <td><?php echo e($appointment->patient->mobile); ?></td>
                                                <td>
                                                    <?php echo e(optional($appointment->timeSlot)->from ? \Carbon\Carbon::parse(optional($appointment->timeSlot)->from)->format('H:i') . ' a ' . \Carbon\Carbon::parse(optional($appointment->timeSlot)->to)->format('H:i') : 'Sin horario'); ?>

                                                </td>
                                                <td>
                                                    <?php if($appointment->status == 1): ?>
                                                        <span class="badge badge-pill text-white" style="background-color:#198754;">Completado</span>
                                                    <?php elseif($appointment->status == 2): ?>
                                                        <span class="badge badge-pill text-white" style="background-color:#dc3545;">Cancelado</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-pill text-white" style="background-color:#0dcaf0;">Pendiente</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="<?php echo e(url('appointment-view/' . $appointment->id)); ?>" class="btn btn-primary mb-1"><?php echo e(__('Ver')); ?></a>
                                                    <?php if((int) $appointment->status !== 1): ?>
                                                        <button type="button" class="btn btn-success complete mb-1" data-id="<?php echo e($appointment->id); ?>"><?php echo e(__('Completar')); ?></button>
                                                        <button type="button" class="btn btn-danger cancel mb-1" data-id="<?php echo e($appointment->id); ?>"><?php echo e(__('Cancelar')); ?></button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php
                                                $i++;
                                            ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php elseif($role == 'patient'): ?>
                                        <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td> <?php echo e($i); ?> </td>
                                                <td><?php echo e(@$appointment->doctor->user->first_name . ' ' . @$appointment->doctor->user->last_name); ?>

                                                </td>
                                                <td><?php echo e(@$appointment->doctor->user->mobile); ?></td>
                                                <td>
                                                    <?php echo e(optional($appointment->timeSlot)->from ? \Carbon\Carbon::parse(optional($appointment->timeSlot)->from)->format('H:i') . ' a ' . \Carbon\Carbon::parse(optional($appointment->timeSlot)->to)->format('H:i') : 'Sin horario'); ?>

                                                </td>
                                                <td>
                                                    <?php if($appointment->status == 1): ?>
                                                        <span class="badge badge-pill text-white" style="background-color:#198754;">Completado</span>
                                                    <?php elseif($appointment->status == 2): ?>
                                                        <span class="badge badge-pill text-white" style="background-color:#dc3545;">Cancelado</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-pill text-white" style="background-color:#0dcaf0;">Pendiente</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php
                                                $i++;
                                            ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            <input type="hidden" id="csrf_token_value" value="<?php echo e(csrf_token()); ?>">
                        </div>
                        <div id="new_list" style="display : none"></div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script'); ?>
        <!-- Calender Js-->
        <script src="<?php echo e(URL::asset('build/libs/select2/js/select2.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('build/libs/jquery-ui/jquery-ui.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('build/libs/moment/moment.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('build/libs/fullcalendar/index.global.min.js')); ?>"></script>
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/locales/es.global.min.js"></script>
        <!-- Get App url in Javascript file -->
        <script type="text/javascript">
            var aplist_url = "<?php echo e(url('appointmentList')); ?>";
        </script>
        <!-- Init js-->
        <script src="<?php echo e(URL::asset('build/js/pages/calendar-init.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('build/js/pages/form-advanced.init.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('build/js/pages/appointment.js')); ?>"></script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views/appointment/appointment.blade.php ENDPATH**/ ?>
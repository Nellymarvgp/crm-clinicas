<?php $__env->startSection('title'); ?> <?php echo e(__('Lista de Citas')); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(URL::asset('build/libs/datatables/datatables.min.css')); ?>">
<?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <!-- start page title -->
        <?php $__env->startComponent('components.breadcrumb'); ?>
            <?php $__env->slot('title'); ?> Lista de Citas <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_1'); ?> Panel <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_2'); ?> Citas <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
        <!-- end page title -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#PendingAppointmentList" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block"><?php echo e(__('Lista de Citas Pendientes')); ?></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#UpcomingAppointmentList" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block"><?php echo e(__('Lista de Próximas Citas')); ?></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#ComplateAppointmentList" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block"><?php echo e(__('Lista de Citas Completadas')); ?></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#CancelAppointmentList" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block"><?php echo e(__('Lista de Citas Canceladas')); ?></span>
                                </a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="PendingAppointmentList" role="tabpanel">
                                <table class="table table-bordered dt-responsive nowrap datatable"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th><?php echo e(__('Nro.')); ?></th>
                                            <th><?php echo e(__('Nombre del Odontólogo')); ?></th>
                                            <th><?php echo e(__('Nombre del Paciente')); ?></th>
                                            <th><?php echo e(__('Teléfono del Paciente')); ?></th>
                                            <th><?php echo e(__('Correo del Paciente')); ?></th>
                                            <th><?php echo e(__('Fecha')); ?></th>
                                            <th><?php echo e(__('Hora')); ?></th>
                                            <th><?php echo e(__('Estado')); ?></th>
                                            <th><?php echo e(__('Acción')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(session()->has('page_limit')): ?>
                                            <?php
                                                $per_page = session()->get('page_limit');
                                            ?>
                                        <?php else: ?>
                                            <?php
                                                $per_page = Config::get('app.page_limit');
                                            ?>
                                        <?php endif; ?>
                                        <?php
                                            $currentpage = $pending_appointment->currentPage();
                                        ?>
                                        <?php $__currentLoopData = $pending_appointment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td> <?php echo e($loop->index + 1 + $per_page * ($currentpage - 1)); ?> </td>
                                                <td> <?php echo e(@$item->doctor->user->first_name . ' ' . @$item->doctor->user->last_name); ?>

                                                </td>
                                                <td> <?php echo e($item->patient->first_name . ' ' . $item->patient->last_name); ?>

                                                </td>
                                                <td> <?php echo e($item->patient->mobile); ?> </td>
                                                <td> <?php echo e($item->patient->email); ?> </td>
                                                <td><?php echo e($item->appointment_date); ?></td>
                                                <td><?php echo e($item->time_range_label); ?></td>
                                                <td>
                                                    <?php if($item->status == 1): ?>
                                                        <span class="badge badge-pill text-white" style="background-color:#198754;">Completado</span>
                                                    <?php elseif($item->status == 2): ?>
                                                        <span class="badge badge-pill text-white" style="background-color:#dc3545;">Cancelado</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-pill text-white" style="background-color:#0dcaf0;">Pendiente</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="<?php echo e(url('appointment-view/' . $item->id)); ?>" class="btn btn-primary btn-sm mb-1">Ver</a>
                                                    <?php if(($role == 'doctor' || $role == 'receptionist') && (int) $item->status !== 1): ?>
                                                        <button type="button" class="btn btn-success complete"
                                                            data-id="<?php echo e($item->id); ?>">Completar</button>
                                                    <?php endif; ?>
                                                    <?php if((int) $item->status !== 1): ?>
                                                        <button type="button" class="btn btn-danger cancel"
                                                            data-id="<?php echo e($item->id); ?>">Cancelar</button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="UpcomingAppointmentList" role="tabpanel">
                                <table class="table table-bordered dt-responsive nowrap datatable"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th><?php echo e(__('Nro.')); ?></th>
                                            <th><?php echo e(__('Nombre del Odontólogo')); ?></th>
                                            <th><?php echo e(__('Nombre del Paciente')); ?></th>
                                            <th><?php echo e(__('Teléfono del Paciente')); ?></th>
                                            <th><?php echo e(__('Correo del Paciente')); ?></th>
                                            <th><?php echo e(__('Fecha')); ?></th>
                                            <th><?php echo e(__('Hora')); ?></th>
                                            <th><?php echo e(__('Estado')); ?></th>
                                            <th><?php echo e(__('Acción')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(session()->has('page_limit')): ?>
                                            <?php
                                                $per_page = session()->get('page_limit');
                                            ?>
                                        <?php else: ?>
                                            <?php
                                                $per_page = Config::get('app.page_limit');
                                            ?>
                                        <?php endif; ?>
                                        <?php
                                            $currentpage = $Upcoming_appointment->currentPage();
                                        ?>
                                        <?php $__currentLoopData = $Upcoming_appointment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td> <?php echo e($loop->index + 1 + $per_page * ($currentpage - 1)); ?> </td>
                                                <td> <?php echo e(@$item->doctor->user->first_name . ' ' . @$item->doctor->user->last_name); ?>

                                                </td>
                                                <td> <?php echo e($item->patient->first_name . ' ' . $item->patient->last_name); ?>

                                                </td>
                                                <td> <?php echo e($item->patient->mobile); ?> </td>
                                                <td><?php echo e($item->patient->email); ?></td>
                                                <td><?php echo e($item->appointment_date); ?></td>
                                                <td><?php echo e($item->time_range_label); ?></td>
                                                <td>
                                                    <?php if($item->status == 1): ?>
                                                        <span class="badge badge-pill text-white" style="background-color:#198754;">Completado</span>
                                                    <?php elseif($item->status == 2): ?>
                                                        <span class="badge badge-pill text-white" style="background-color:#dc3545;">Cancelado</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-pill text-white" style="background-color:#0dcaf0;">Pendiente</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="<?php echo e(url('appointment-view/' . $item->id)); ?>" class="btn btn-primary btn-sm mb-1">Ver</a>
                                                    <?php if(($role == 'doctor' || $role == 'receptionist' || $role == 'admin') && (int) $item->status !== 1): ?>
                                                        <button type="button" class="btn btn-success btn-sm complete mb-1" data-id="<?php echo e($item->id); ?>">Completar</button>
                                                        <button type="button" class="btn btn-danger btn-sm cancel mb-1" data-id="<?php echo e($item->id); ?>">Cancelar</button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="ComplateAppointmentList" role="tabpanel">
                                <table class="table table-bordered dt-responsive nowrap datatable"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th><?php echo e(__('Nro.')); ?></th>
                                            <th><?php echo e(__('Nombre del Odontólogo')); ?></th>
                                            <th><?php echo e(__('Nombre del Paciente')); ?></th>
                                            <th><?php echo e(__('Teléfono del Paciente')); ?></th>
                                            <th><?php echo e(__('Correo del Paciente')); ?></th>
                                            <th><?php echo e(__('Fecha')); ?></th>
                                            <th><?php echo e(__('Hora')); ?></th>
                                            <th><?php echo e(__('Estado')); ?></th>
                                            <th><?php echo e(__('Acción')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(session()->has('page_limit')): ?>
                                            <?php
                                                $per_page = session()->get('page_limit');
                                            ?>
                                        <?php else: ?>
                                            <?php
                                                $per_page = Config::get('app.page_limit');
                                            ?>
                                        <?php endif; ?>
                                        <?php
                                            $currentpage = $Complete_appointment->currentPage();
                                        ?>
                                        <?php $__currentLoopData = $Complete_appointment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td> <?php echo e($loop->index + 1 + $per_page * ($currentpage - 1)); ?> </td>
                                                <td> <?php echo e(@$item->doctor->user->first_name . ' ' . @$item->doctor->user->last_name); ?>

                                                </td>
                                                <td> <?php echo e($item->patient->first_name . ' ' . $item->patient->last_name); ?>

                                                </td>
                                                <td> <?php echo e($item->patient->mobile); ?> </td>
                                                <td><?php echo e($item->patient->email); ?></td>
                                                <td><?php echo e($item->appointment_date); ?></td>
                                                <td><?php echo e($item->time_range_label); ?></td>
                                                <td>
                                                    <?php if($item->status == 1): ?>
                                                        <span class="badge badge-pill text-white" style="background-color:#198754;">Completado</span>
                                                    <?php elseif($item->status == 2): ?>
                                                        <span class="badge badge-pill text-white" style="background-color:#dc3545;">Cancelado</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-pill text-white" style="background-color:#0dcaf0;">Pendiente</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="<?php echo e(url('appointment-view/' . $item->id)); ?>" class="btn btn-primary btn-sm mb-1">Ver</a>
                                                    <?php if(($role == 'doctor' || $role == 'receptionist' || $role == 'admin') && (int) $item->status !== 1): ?>
                                                        <button type="button" class="btn btn-success btn-sm complete mb-1" data-id="<?php echo e($item->id); ?>">Completar</button>
                                                        <button type="button" class="btn btn-danger btn-sm cancel mb-1" data-id="<?php echo e($item->id); ?>">Cancelar</button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="CancelAppointmentList" role="tabpanel">
                                <table class="table table-bordered dt-responsive nowrap datatable"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th><?php echo e(__('Nro.')); ?></th>
                                            <th><?php echo e(__('Nombre del Odontólogo')); ?></th>
                                            <th><?php echo e(__('Nombre del Paciente')); ?></th>
                                            <th><?php echo e(__('Teléfono del Paciente')); ?></th>
                                            <th><?php echo e(__('Correo del Paciente')); ?></th>
                                            <th><?php echo e(__('Fecha')); ?></th>
                                            <th><?php echo e(__('Hora')); ?></th>
                                            <th><?php echo e(__('Estado')); ?></th>
                                            <th><?php echo e(__('Acción')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(session()->has('page_limit')): ?>
                                            <?php
                                                $per_page = session()->get('page_limit');
                                            ?>
                                        <?php else: ?>
                                            <?php
                                                $per_page = Config::get('app.page_limit');
                                            ?>
                                        <?php endif; ?>
                                        <?php
                                            $currentpage = $Cancel_appointment->currentPage();
                                        ?>
                                        <?php $__currentLoopData = $Cancel_appointment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td> <?php echo e($loop->index + 1 + $per_page * ($currentpage - 1)); ?> </td>
                                                <td> <?php echo e(@$item->doctor->user->first_name . ' ' . @$item->doctor->user->last_name); ?>

                                                </td>
                                                <td> <?php echo e($item->patient->first_name . ' ' . $item->patient->last_name); ?>

                                                </td>
                                                <td> <?php echo e($item->patient->mobile); ?> </td>
                                                <td><?php echo e($item->patient->email); ?></td>
                                                <td><?php echo e($item->appointment_date); ?></td>
                                                <td><?php echo e($item->time_range_label); ?></td>
                                                <td>
                                                    <?php if($item->status == 1): ?>
                                                        <span class="badge badge-pill text-white" style="background-color:#198754;">Completado</span>
                                                    <?php elseif($item->status == 2): ?>
                                                        <span class="badge badge-pill text-white" style="background-color:#dc3545;">Cancelado</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-pill text-white" style="background-color:#0dcaf0;">Pendiente</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="<?php echo e(url('appointment-view/' . $item->id)); ?>" class="btn btn-primary btn-sm mb-1">Ver</a>
                                                    <?php if(($role == 'doctor' || $role == 'receptionist' || $role == 'admin') && (int) $item->status !== 1): ?>
                                                        <button type="button" class="btn btn-success btn-sm complete mb-1" data-id="<?php echo e($item->id); ?>">Completar</button>
                                                        <button type="button" class="btn btn-danger btn-sm cancel mb-1" data-id="<?php echo e($item->id); ?>">Cancelar</button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                            <input type="hidden" id="csrf_token_value" value="<?php echo e(csrf_token()); ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script'); ?>
        <!-- Plugins js -->
        <script src="<?php echo e(URL::asset('build/libs/datatables/datatables.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('build/libs/jszip/jszip.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('build/libs/pdfmake/build/pdfmake.min.js')); ?>"></script>
        <!-- Init js-->
        <script src="<?php echo e(URL::asset('build/js/pages/datatables.init.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('build/js/pages/notification.init.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('build/js/pages/appointment.js')); ?>"></script>
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script-bottom'); ?>
        <script>
            // active tab
            if (window.location.href) {
                var url = window.location.href;
                var activeTab = url.substring(url.indexOf("#") + 1);
                var URL = document.location.origin;
                if (url.substring(url.indexOf("#") + 1) == URL + '/appointment-list') {
                    $("#PendingAppointmentList").addClass("active in");
                } else {
                    $(".tab-pane").removeClass("active in");
                    $("#" + activeTab).addClass("active in");
                    $('a[href="#' + activeTab + '"]').tab('show')
                }
            }
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views\appointment\appointment-list.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title'); ?> <?php echo e(__('Perfil del Paciente')); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(URL::asset('build/libs/datatables/datatables.min.css')); ?>">
<?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <!-- start page title -->
        <?php $__env->startComponent('components.breadcrumb'); ?>
            <?php $__env->slot('title'); ?> Perfil del Paciente <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_1'); ?> Panel <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_2'); ?> Perfil del Paciente <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
        <!-- end page title -->
        <div class="row">
            <div class="col-xl-4">
                <div class="card overflow-hidden">
                    <div class="bg-primary-subtle">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-3">
                                    <h5 class="text-primary"><?php echo e(__('Información del Paciente')); ?></h5>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="<?php echo e(URL::asset('build/images/profile-img.png')); ?>" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="avatar-md profile-user-wid mb-4">
                                    <img src="<?php if($patient->profile_photo != null): ?><?php echo e(URL::asset('storage/images/users/' . $patient->profile_photo)); ?><?php else: ?><?php echo e(URL::asset('build/images/users/noImage.png')); ?><?php endif; ?>" alt="<?php echo e($patient->first_name); ?>"
                                        class="img-thumbnail rounded-circle">
                                </div>
                                <h5 class="font-size-15 text-truncate"> <?php echo e($patient->first_name); ?>

                                    <?php echo e($patient->last_name); ?></h5>
                            </div>
                            <div class="col-sm-8">
                                <div class="pt-4">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5 class="font-size-12"><?php echo e(__('Último acceso:')); ?></h5>
                                            <p class="text-muted mb-0"> <?php echo e($patient->last_login); ?> </p>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <a href="<?php echo e(url('profile-edit')); ?>"
                                            class="btn btn-primary waves-effect waves-light btn-sm"><?php echo e(__('Editar Perfil ')); ?><i
                                                class="mdi mdi-arrow-right ms-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4"><?php echo e(__('Información Personal')); ?></h4>
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <tbody>
                                    <tr>
                                        <th scope="row"><?php echo e(__('Nombre Completo:')); ?></th>
                                        <td><?php echo e($patient->first_name); ?> <?php echo e($patient->last_name); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo e(__('Nro. de Contacto:')); ?></th>
                                        <td> <?php echo e(@$patient->mobile); ?> </td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo e(__('Email:')); ?></th>
                                        <td> <?php echo e($patient->email); ?> </td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo e(__('Edad:')); ?></th>
                                        <td> <?php echo e(@$patient_info->age); ?> </td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo e(__('Género:')); ?></th>
                                        <td>
                                            <?php echo e(strtolower((string) @$patient_info->gender) === 'female' ? 'Femenino' : (strtolower((string) @$patient_info->gender) === 'male' ? 'Masculino' : @$patient_info->gender)); ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo e(__('Dirección:')); ?></th>
                                        <td> <?php echo e(@$patient_info->address); ?> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- end card -->
            </div>
            <div class="col-xl-8">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium"><?php echo e(__('Citas')); ?></p>
                                        <h4 class="mb-0"><?php echo e(number_format($data['total_appointment'])); ?></h4>
                                    </div>
                                    <div class="mini-stat-icon avatar-sm align-self-center rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-check-circle font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium"><?php echo e(__('Facturas Pendientes')); ?></p>
                                        <h4 class="mb-0"><?php echo e(number_format($data['pending_bill'])); ?></h4>
                                    </div>
                                    <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-hourglass font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium"><?php echo e(__('Total Facturado')); ?></p>
                                        <h4 class="mb-0">$<?php echo e(number_format($data['revenue'], 2)); ?></h4>
                                    </div>
                                    <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-package font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#Medical_info" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block"><?php echo e(__('Información Médica')); ?></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#DentalHistory" role="tab">
                                    <span class="d-none d-sm-block"><?php echo e(__('Historia Dental')); ?></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#AppointmentList" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block"><?php echo e(__('Lista de Citas')); ?></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#PrescriptionList" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block"><?php echo e(__('Lista de Recetas')); ?></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#Invoices" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block"><?php echo e(__('Facturas')); ?></span>
                                </a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="Medical_info" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <tbody>
                                            <tr>
                                                <th scope="row"><?php echo e(__('Estatura')); ?></th>
                                                <td> <?php echo e(@$medical_Info->height); ?> </td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo e(__('Peso')); ?></th>
                                                <td> <?php echo e(@$medical_Info->weight); ?> </td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo e(__('Grupo Sanguíneo')); ?></th>
                                                <td> <?php echo e(@$medical_Info->b_group); ?> </td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo e(__('Presión Arterial')); ?></th>
                                                <td> <?php echo e(@$medical_Info->b_pressure); ?> </td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo e(__('Pulso')); ?></th>
                                                <td> <?php echo e(@$medical_Info->pulse); ?> </td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo e(__('Respiración')); ?></th>
                                                <td> <?php echo e(@$medical_Info->respiration); ?> </td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo e(__('Alergia')); ?></th>
                                                <td> <?php echo e(@$medical_Info->allergy); ?> </td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo e(__('Dieta')); ?></th>
                                                <td>
                                                    <?php if(($medical_Info->diet ?? '') === 'Vegetarian'): ?> Vegetariana
                                                    <?php elseif(($medical_Info->diet ?? '') === 'Non-vegetarian'): ?> No vegetariana
                                                    <?php elseif(($medical_Info->diet ?? '') === 'Vegan'): ?> Vegana
                                                    <?php else: ?> <?php echo e($medical_Info->diet ?? ''); ?>

                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <tr><th scope="row"><?php echo e(__('Diabetes')); ?></th><td><?php echo e(($medical_Info->diabetes_status ?? '') === 'si' ? 'Si' : (($medical_Info->diabetes_status ?? '') === 'no' ? 'No' : '')); ?></td></tr>
                                            <tr><th scope="row"><?php echo e(__('Diabetes controlado')); ?></th><td><?php echo e(($medical_Info->diabetes_controlled ?? '') === 'si' ? 'Si' : (($medical_Info->diabetes_controlled ?? '') === 'no' ? 'No' : '')); ?></td></tr>
                                            <tr><th scope="row"><?php echo e(__('Hipertensión')); ?></th><td><?php echo e(($medical_Info->hypertension_status ?? '') === 'si' ? 'Si' : (($medical_Info->hypertension_status ?? '') === 'no' ? 'No' : '')); ?></td></tr>
                                            <tr><th scope="row"><?php echo e(__('Hipertensión controlada')); ?></th><td><?php echo e(($medical_Info->hypertension_controlled ?? '') === 'si' ? 'Si' : (($medical_Info->hypertension_controlled ?? '') === 'no' ? 'No' : '')); ?></td></tr>
                                            <tr><th scope="row"><?php echo e(__('Actualmente embarazada')); ?></th><td><?php echo e(($medical_Info->currently_pregnant ?? '') === 'si' ? 'Si' : (($medical_Info->currently_pregnant ?? '') === 'no' ? 'No' : '')); ?></td></tr>
                                            <tr><th scope="row"><?php echo e(__('Antecedentes de infarto')); ?></th><td><?php echo e(($medical_Info->heart_attack_history ?? '') === 'si' ? 'Si' : (($medical_Info->heart_attack_history ?? '') === 'no' ? 'No' : '')); ?></td></tr>
                                            <tr><th scope="row"><?php echo e(__('Último infarto')); ?></th><td><?php echo e($medical_Info->last_heart_attack ?? ''); ?></td></tr>
                                            <tr><th scope="row"><?php echo e(__('Consume medicamentos')); ?></th><td><?php echo e(($medical_Info->takes_medications ?? '') === 'si' ? 'Si' : (($medical_Info->takes_medications ?? '') === 'no' ? 'No' : '')); ?></td></tr>
                                            <tr><th scope="row"><?php echo e(__('Medicamentos')); ?></th><td><?php echo e($medical_Info->medications_list ?? ''); ?></td></tr>
                                            <tr><th scope="row"><?php echo e(__('Aspirina en las últimas 72 horas')); ?></th><td><?php echo e(($medical_Info->aspirin_last_72h ?? '') === 'si' ? 'Si' : (($medical_Info->aspirin_last_72h ?? '') === 'no' ? 'No' : '')); ?></td></tr>
                                            <tr><th scope="row"><?php echo e(__('Padece alguna enfermedad')); ?></th><td><?php echo e(($medical_Info->has_disease ?? '') === 'si' ? 'Si' : (($medical_Info->has_disease ?? '') === 'no' ? 'No' : '')); ?></td></tr>
                                            <tr><th scope="row"><?php echo e(__('Enfermedad')); ?></th><td><?php echo e($medical_Info->disease_details ?? ''); ?></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="DentalHistory" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead><tr><th><?php echo e(__('Fecha')); ?></th><th><?php echo e(__('Diagnóstico')); ?></th><th><?php echo e(__('Tratamiento')); ?></th><th><?php echo e(__('Cantidad')); ?></th><th><?php echo e(__('Valor')); ?></th><th><?php echo e(__('Detalle')); ?></th></tr></thead>
                                        <tbody>
                                            <?php $__empty_2 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                <?php if($item->dentalEvaluation): ?>
                                                    <tr>
                                                        <td><?php echo e($item->appointment_date); ?></td>
                                                        <td><?php echo e($item->dentalEvaluation->diagnosis ?: __('Sin registrar')); ?></td>
                                                        <td><?php echo e($item->dentalEvaluation->treatment ?: __('Sin registrar')); ?></td>
                                                        <td><?php echo e($item->dentalEvaluation->quantity ?: '0'); ?></td>
                                                        <td><?php echo e($item->dentalEvaluation->value !== null ? number_format($item->dentalEvaluation->value, 2) : '0.00'); ?></td>
                                                        <td><a href="<?php echo e(url('appointment-view/' . $item->id)); ?>#dental-history" class="btn btn-primary btn-sm"><?php echo e(__('Ver')); ?></a></td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                <tr><td colspan="6"><?php echo e(__('Sin evaluaciones registradas')); ?></td></tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="AppointmentList" role="tabpanel">
                                <table class="table table-bordered dt-responsive nowrap "
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th><?php echo e(__('Nro.')); ?></th>
                                            <th>Doctor</th>
                                            <th><?php echo e(__('Fecha')); ?></th>
                                            <th><?php echo e(__('Hora')); ?></th>
                                        </tr>
                                    </thead>
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
                                        $currentpage = $appointments->currentPage();
                                    ?>
                                    <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($loop->index + 1); ?></td>
                                            <td><?php echo e(@$item->doctor->user->first_name); ?> <?php echo e(@$item->doctor->user->last_name); ?></td>
                                            <td><?php echo e($item->appointment_date); ?></td>
                                            <td><?php echo e(optional($item->timeSlot)->from ? optional($item->timeSlot)->from . ' to ' . optional($item->timeSlot)->to : 'Sin horario'); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                                <div class="col-md-12 text-center mt-3">
                                    <div class="d-flex justify-content-start">
                                        Mostrando <?php echo e($appointments->firstItem()); ?> a <?php echo e($appointments->lastItem()); ?> de
                                        <?php echo e($appointments->total()); ?> registros
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <?php echo e($appointments->links()); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="PrescriptionList" role="tabpanel">
                                <table class="table table-bordered dt-responsive nowrap "
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th><?php echo e(__('Nro.')); ?></th>
                                            <th>Doctor</th>
                                            <th><?php echo e(__('Fecha')); ?></th>
                                            <th><?php echo e(__('Opción')); ?></th>
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
                                        $currentpage = $prescriptions->currentPage();
                                    ?>
                                        <?php $__currentLoopData = $prescriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td> <?php echo e($loop->index + 1); ?> </td>
                                                <td><?php echo e(@$item->doctor->user->first_name); ?> <?php echo e(@$item->doctor->user->last_name); ?>

                                                </td>
                                                <td><?php echo e(date('d-m-Y', strtotime($item->created_at))); ?></td>
                                                <td>
                                                    <a href="<?php echo e(url('prescription-view/' . $item->id)); ?>">
                                                        <button type="button"
                                                            class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                                            <?php echo e(__('Ver')); ?>

                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                                <div class="col-md-12 text-center mt-3">
                                    <div class="d-flex justify-content-start">
                                        Mostrando <?php echo e($prescriptions->firstItem()); ?> a <?php echo e($prescriptions->lastItem()); ?> de
                                        <?php echo e($prescriptions->total()); ?> registros
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <?php echo e($prescriptions->links()); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="Invoices" role="tabpanel">
                                <table class="table table-bordered dt-responsive nowrap "
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th><?php echo e(__('Nro.')); ?></th>
                                            <th><?php echo e(__('Fecha')); ?></th>
                                            <th><?php echo e(__('Estado')); ?></th>
                                            <th><?php echo e(__('Opción')); ?></th>
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
                                        $currentpage = $prescriptions->currentPage();
                                    ?>
                                        <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td> <?php echo e($loop->index + 1); ?> </td>
                                                <td><?php echo e(date('d-m-Y', strtotime($item->created_at))); ?></td>
                                                <td><?php echo e($item->payment_status); ?></td>
                                                <td>
                                                    <a href="<?php echo e(url('invoice-view/' . $item->id)); ?>">
                                                        <button type="button"
                                                            class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                                            <?php echo e(__('Ver')); ?>

                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                                <div class="col-md-12 text-center mt-3">
                                    <div class="d-flex justify-content-start">
                                        Mostrando <?php echo e($invoices->firstItem()); ?> a <?php echo e($invoices->lastItem()); ?> de
                                        <?php echo e($invoices->total()); ?> registros
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <?php echo e($invoices->links()); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script'); ?>
        <!-- flot plugins -->
        <script src="<?php echo e(URL::asset('build/libs/apexcharts/apexcharts.min.js')); ?>"></script>
        <!-- Plugins js -->
        
        <script src="<?php echo e(URL::asset('build/libs/jszip/jszip.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('build/libs/pdfmake/build/pdfmake.min.js')); ?>"></script>
        <!-- Init js-->
        
        <script src="<?php echo e(URL::asset('build/js/pages/profile.init.js')); ?>"></script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views\patient\patient-profile-view.blade.php ENDPATH**/ ?>
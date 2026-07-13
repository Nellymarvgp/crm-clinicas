<?php $__env->startSection('title'); ?> <?php echo e(__('Prescription Details')); ?> <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <!-- start page title -->
        <?php $__env->startComponent('components.breadcrumb'); ?>
            <?php $__env->slot('title'); ?> Prescription Details <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_1'); ?> Dashboard <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_2'); ?> Prescription List <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_3'); ?> Prescription Details <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
        <!-- end page title -->
        <div class="row d-print-none">
            <div class="col-12">
                <a href="<?php echo e(url('prescription-list')); ?>">
                    <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                        <i
                            class="bx bx-arrow-back font-size-16 align-middle me-2"></i><?php echo e(__('Back to Prescription List')); ?>

                    </button>
                </a>
                <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light mb-4">
                    <i class="fa fa-print"></i>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice-title">
                            <h4 class="float-end font-size-16">Prescription #<?php echo e($user_details->id); ?></h4>
                            <div class="mb-4">
                                <img src="<?php echo e(URL::asset('build/images/logo-dark.png')); ?>" alt="logo" height="20" />
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-5">
                                <address>
                                    <strong><?php echo e(__('Dr')); ?></strong><br>
                                    <?php echo e(@$user_details->appointment->doctor->user->first_name . ' ' . @$user_details->appointment->doctor->user->last_name); ?><br>
                                    <i class="mdi mdi-phone"></i> <?php echo e(@$user_details->appointment->doctor->user->mobile); ?><br>
                                    <i class="mdi mdi-email"></i> <?php echo e(@$user_details->appointment->doctor->user->email); ?><br>
                                </address>
                            </div>
                            <div class="col-4">
                                <address>
                                    <strong><?php echo e(__('Patient')); ?></strong><br>
                                    <?php echo e($user_details->patient->first_name . ' ' . $user_details->patient->last_name); ?><br>
                                    <i class="mdi mdi-phone"></i> <?php echo e($user_details->patient->mobile); ?><br>
                                    <i class="mdi mdi-email"></i> <?php echo e($user_details->patient->email); ?><br>
                                </address>
                            </div>
                            <div class="col-3">
                                <address>
                                    <strong><?php echo e(__('Prescription Date: ')); ?></strong><?php echo e($user_details->created_at); ?><br>
                                    <strong><?php echo e(__('Appointment Date: ')); ?></strong>
                                    <?php echo e($user_details->appointment->appointment_date . ' ' . $user_details->appointment->timeSlot->from . ' to ' . $user_details->appointment->timeSlot->to); ?>

                                    <br>
                                </address>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5 mt-3 text-center">
                                <address>
                                    <strong><?php echo e(__('Symptoms:')); ?></strong><br>
                                    <?php echo e($user_details->symptoms); ?>

                                </address>
                            </div>
                            <div class="col-5 mt-3 text-center">
                                <address>
                                    <strong><?php echo e(__('Diagnosis:')); ?></strong><br>
                                    <?php echo e($user_details->diagnosis); ?>

                                </address>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="py-2 mt-3">
                                    <h3 class="font-size-15 fw-bold"><?php echo e(__('Medications')); ?></h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th style="width: 70px;"><?php echo e(__('No.')); ?></th>
                                                <th><?php echo e(__('Name')); ?></th>
                                                <th><?php echo e(__('Notes')); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $medicines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($loop->index + 1); ?></td>
                                                    <td><?php echo e($item->name); ?></td>
                                                    <td><?php echo e($item->notes); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="py-2 mt-3">
                                    <h3 class="font-size-15 fw-bold"><?php echo e(__('Test Reports')); ?></h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th style="width: 70px;"><?php echo e(__('No.')); ?></th>
                                                <th><?php echo e(__('Name')); ?></th>
                                                <th><?php echo e(__('Notes')); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $test_reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($loop->index + 1); ?></td>
                                                    <td> <?php echo e($item->name); ?> </td>
                                                    <td> <?php echo e($item->notes); ?> </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views\patient\patient-prescription-view.blade.php ENDPATH**/ ?>
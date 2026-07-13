<?php $__env->startSection('title'); ?> <?php echo e(__('Appointment list')); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(URL::asset('build/libs/datatables/datatables.min.css')); ?>">
<?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <!-- start page title -->
        <?php $__env->startComponent('components.breadcrumb'); ?>
            <?php $__env->slot('title'); ?> Appointment List <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_1'); ?> Dashboard <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_2'); ?> Appointment <?php $__env->endSlot(); ?>
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
                                    <span class="d-none d-sm-block"><?php echo e(__('Pending Appointment List')); ?></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#UpcomingAppointmentList" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block"><?php echo e(__('Upcoming Appointment List')); ?></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#ComplateAppointmentList" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block"><?php echo e(__('Complete Appointment List')); ?></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#CancelAppointmentList" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block"><?php echo e(__('Cancel Appointment List')); ?></span>
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
                                            <th><?php echo e(__('Sr. No')); ?></th>
                                            <th><?php echo e(__('Doctor Name')); ?></th>
                                            <th><?php echo e(__('Patient Name')); ?></th>
                                            <th><?php echo e(__('Patient Contact No')); ?></th>
                                            <th><?php echo e(__('Patient Email')); ?></th>
                                            <th><?php echo e(__('Date')); ?></th>
                                            <th><?php echo e(__('Time')); ?></th>
                                            <th><?php echo e(__('Status')); ?></th>
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
                                                <td><?php echo e($item->timeSlot->from . ' to ' . $item->timeSlot->to); ?></td>
                                                <td>
                                                    <?php if($role == 'doctor' || $role == 'receptionist'): ?>
                                                        <button type="button" class="btn btn-success complete"
                                                            data-id="<?php echo e($item->id); ?>">Complete</button>
                                                    <?php endif; ?>
                                                    <button type="button" class="btn btn-danger cancel"
                                                        data-id="<?php echo e($item->id); ?>">Cancel</button>
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
                                            <th><?php echo e(__('Sr. No')); ?></th>
                                            <th><?php echo e(__('Doctor Name')); ?></th>
                                            <th><?php echo e(__('Patient Name')); ?></th>
                                            <th><?php echo e(__('Patient Contact No')); ?></th>
                                            <th><?php echo e(__('Patient Email')); ?></th>
                                            <th><?php echo e(__('Date')); ?></th>
                                            <th><?php echo e(__('Time')); ?></th>
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
                                                <td><?php echo e($item->timeSlot->from . ' to ' . $item->timeSlot->to); ?></td>
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
                                            <th><?php echo e(__('Sr. No')); ?></th>
                                            <th><?php echo e(__('Doctor Name')); ?></th>
                                            <th><?php echo e(__('Patient Name')); ?></th>
                                            <th><?php echo e(__('Patient Contact No')); ?></th>
                                            <th><?php echo e(__('Patient Email')); ?></th>
                                            <th><?php echo e(__('Date')); ?></th>
                                            <th><?php echo e(__('Time')); ?></th>
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
                                                <td><?php echo e($item->timeSlot->from . ' to ' . $item->timeSlot->to); ?></td>
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
                                            <th><?php echo e(__('Sr. No')); ?></th>
                                            <th><?php echo e(__('Doctor Name')); ?></th>
                                            <th><?php echo e(__('Patient Name')); ?></th>
                                            <th><?php echo e(__('Patient Contact No')); ?></th>
                                            <th><?php echo e(__('Patient Email')); ?></th>
                                            <th><?php echo e(__('Date')); ?></th>
                                            <th><?php echo e(__('Time')); ?></th>
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
                                                <td><?php echo e($item->timeSlot->from . ' to ' . $item->timeSlot->to); ?></td>
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
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script'); ?>
        <!-- Plugins js -->
        <script src="<?php echo e(URL::asset('build/libs/datatables/datatables.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('build/libs/jszip/jszip.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('build/libs/pdfmake/build/pdfmake.min.js')); ?>"></script>
        <!-- Init js-->
        <script src="<?php echo e(URL::asset('build/js/pages/datatables.init.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('build/js/pages/notification.init.js')); ?>"></script>
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script-bottom'); ?>
        <script>
            // complete appointment
            $('.complete').click(function(e) {
                var id = $(this).data('id');
                var token = $("input[name='_token']").val();
                var status = 1;
                if (confirm('Are you sure you want to confirm appointment?')) {
                    $.ajax({
                        type: "post",
                        url: "appointment-status/" + id,
                        data: {
                            'appointment_id': id,
                            '_token': token,
                            'status': status
                        },
                        beforeSend: function() {
                            $('#preloader').show()
                        },
                        success: function(response) {
                            toastr.success(reponse.Message);
                            location.reload();
                        },
                        error: function(response) {
                            toastr.error(response.responseJSON.message);
                        },
                        complete: function() {
                            $('#preloader').hide();
                        }
                    });
                }
            });
            // cancel appointment
            $('.cancel').click(function(e) {
                var id = $(this).data('id');
                var token = $("input[name='_token']").val();
                var status = 2;
                if (confirm('Are you sure you want to cancel appointment?')) {
                    $.ajax({
                        type: "post",
                        url: "appointment-status/" + id,
                        data: {
                            'appointment_id': id,
                            '_token': token,
                            'status': status
                        },
                        beforeSend: function() {
                            $('#preloader').show()
                        },
                        success: function(response) {
                            toastr.success(reponse.Message);
                            location.reload();
                        },
                        error: function(response) {
                            toastr.error(response.responseJSON.message);
                        },
                        complete: function() {
                            $('#preloader').hide();
                        }
                    });
                }
            });
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
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18"><?php echo e(__('translation.dashboards')); ?></h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active"><?php echo e(__('translation.welcome-to-dashboard')); ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-xl-4">
        <div class="card overflow-hidden">
            <div class="bg-primary-subtle">
                <div class="row">
                    <div class="col-7">
                        <div class="text-primary p-3">
                            <h5 class="text-primary"><?php echo e(__('translation.welcome-back')); ?> !</h5>
                            <p><?php echo e(__('translation.dashboards')); ?></p>
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
                            <img src="<?php if($user->profile_photo != null): ?><?php echo e(URL::asset('storage/images/users/' . $user->profile_photo)); ?><?php else: ?><?php echo e(URL::asset('build/images/users/noImage.png')); ?><?php endif; ?>" class="img-thumbnail rounded-circle">
                        </div>
                        <h5 class="font-size-15 text-truncate"> <?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?> </h5>
                        <p class="text-muted mb-0 text-truncate"><?php echo e(__('translation.patients')); ?></p>
                    </div>
                    <div class="col-sm-8">
                        <div class="pt-4">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="font-size-12"><?php echo e(__('translation.last-login')); ?>:</h5>
                                    <p class="text-muted mb-0"> <?php echo e($user->last_login); ?> </p>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12">
                                    <a href="<?php echo e(url('profile-edit')); ?>" class="btn btn-primary waves-effect waves-light btn-sm"><?php echo e(__('translation.edit-profile')); ?>

                                        <i class="mdi mdi-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4"><?php echo e(__('translation.monthly-expense')); ?></h4>
                <div class="row">
                    <div class="col-sm-6">
                        <p class="text-muted"><?php echo e(__('translation.this-month')); ?></p>
                        <h3>$<?php echo e(number_format($data['monthly_earning'])); ?></h3>
                        <p class="text-muted"><span class="<?php if($data['monthly_diff'] > 0): ?> text-success <?php else: ?> text-danger <?php endif; ?> me-2"> <?php echo e($data['monthly_diff']); ?>% <i class="mdi <?php if($data['monthly_diff'] > 0): ?> mdi-arrow-up <?php else: ?> mdi-arrow-down <?php endif; ?>"></i> </span>
                            <?php echo e(__('translation.from-previous-month')); ?></p>
                    </div>
                    <div class="col-sm-6">
                        <div id="radialBar-chart" class="apex-charts"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="row">
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium"><?php echo e(__('translation.appointments')); ?></p>
                                <h4 class="mb-1"><?php echo e(number_format($data['total_appointment'])); ?></h4>
                            </div>
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                                <span class="avatar-title">
                                    <i class="bx bxs-calendar-check font-size-24"></i>
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
                            <?php if(session()->has('page_limit')): ?>
                            <?php
                            $per_page = session()->get('page_limit');
                            ?>
                            <?php else: ?>
                            <?php
                            $per_page = Config::get('app.page_limit');
                            ?>
                            <?php endif; ?>
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium"><?php echo e(__('translation.items-per-page')); ?></p>
                                <button class="btn  <?php echo e($per_page == 10 ? 'btn-primary' : 'btn-info'); ?>  btn-sm me-2 per-page-items  mb-md-1" data-page="10">10</button>
                                <button class="btn  <?php echo e($per_page == 25 ? 'btn-primary' : 'btn-info'); ?>  btn-sm me-2 per-page-items  mb-md-1" data-page="25">25</button>
                                <button class="btn  <?php echo e($per_page == 50 ? 'btn-primary' : 'btn-info'); ?>  btn-sm me-2 per-page-items  mb-md-1" data-page="50">50</button>
                                <button class="btn  <?php echo e($per_page == 100 ? 'btn-primary' : 'btn-info'); ?>  btn-sm me-2 per-page-items  mb-md-1" data-page="100">100</button>
                            </div>
                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                <span class="avatar-title rounded-circle bg-primary">
                                    <i class="bx bx-book-open font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4"><?php echo e(__('translation.latest-appointment')); ?></h4>
                <div class="table-responsive">
                    <table class="table table-centered table-nowrap mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th><?php echo e(__('Nro.')); ?></th>
                                <th><?php echo e(__('Nombre del Odontólogo')); ?></th>
                                <th><?php echo e(__('Fecha')); ?></th>
                                <th><?php echo e(__('Hora')); ?></th>
                                <th><?php echo e(__('Estado')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($loop->index + 1); ?></td>
                                <td><?php echo e(@$item->doctor->user->first_name); ?> <?php echo e(@$item->doctor->user->last_name); ?></td>
                                <td><?php echo e($item->appointment_date); ?></td>
                                <td><?php echo e($item->timeSlot->from . ' to ' . $item->timeSlot->to); ?></td>
                                <td>
                                    <?php if($item->status == 0): ?>
                                    <span class="badge bg-warning">Pendiente</span>
                                    <?php elseif($item->status == 1 ): ?>
                                    <span class="badge bg-success">Completado</span>
                                    <?php elseif($item->status == 2 ): ?>
                                    <span class="badge bg-danger">Cancelado</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <!-- end table-responsive -->
            </div>
        </div>
    </div>
</div>
<!-- end row -->
<?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views\layouts\patient-dashboard.blade.php ENDPATH**/ ?>
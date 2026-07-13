<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(url('/dashboard')); ?>">
                            <i class="bx bx-home-circle me-2"></i><?php echo e(__('translation.dashboards')); ?>

                        </a>
                    </li>
                    <?php if($role == 'admin'): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#!" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class='bx bx-plus-medical me-2'></i></i><?php echo e(__('translation.doctors')); ?>

                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="<?php echo e(url('doctor')); ?>" class="dropdown-item"><?php echo e(__('translation.list-of-doctors')); ?></a>
                                <a href="<?php echo e(route('doctor.create')); ?>" class="dropdown-item"><?php echo e(__('translation.add-new-doctor')); ?></a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#!" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bx bxs-user-detail me-2"></i><?php echo e(__('translation.patients')); ?> 
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="<?php echo e(url('patient')); ?>" class="dropdown-item"><?php echo e(__('translation.list-of-patients')); ?></a>
                                <a href="<?php echo e(route('patient.create')); ?>" class="dropdown-item"><?php echo e(__('translation.add-new-patient')); ?></a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#!" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bx bx-user-voice me-2"></i><?php echo e(__('translation.receptionist')); ?> 
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="<?php echo e(url('receptionist')); ?>" class="dropdown-item"><?php echo e(__('translation.list-of-receptionist')); ?></a>
                                <a href="<?php echo e(route('receptionist.create')); ?>" class="dropdown-item"><?php echo e(__('translation.add-new-receptionist')); ?></a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#!" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bx bx-user-circle me-2"></i><?php echo e(__('translation.accountant')); ?> <div
                                    class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="<?php echo e(url('accountant')); ?>"
                                    class="dropdown-item"><?php echo e(__('translation.list-of-accountant')); ?></a>
                                <a href="<?php echo e(route('accountant.create')); ?>"
                                    class="dropdown-item"><?php echo e(__('translation.add-new-accountant')); ?></a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#!" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bx bx-layout me-2"></i><span><?php echo e(__('translation.other')); ?></span>
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown">
                                    <a class="dropdown-item dropdown-toggle arrow-none" href="#!" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span><?php echo e(__('translation.department')); ?></span>
                                        <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu">
                                        <a href="<?php echo e(url('department')); ?>"
                                            class="dropdown-item"><?php echo e(__('translation.list-of-department')); ?></a>
                                        <a href="<?php echo e(route('department.create')); ?>"
                                            class="dropdown-item"><?php echo e(__('translation.add-new-department')); ?></a>
                                    </div>
                                </div>
                                <a class="dropdown-item" href="<?php echo e(url('pending-appointment')); ?>"
                                ><span><?php echo e(__('translation.appointment-list')); ?></span></a>
                                <a class="dropdown-item" href="<?php echo e(url('transaction')); ?>"
                                ><span><?php echo e(__('translation.transaction')); ?></span></a>
                                <a class="dropdown-item" href="<?php echo e(url('app-setting')); ?>"
                                ><span><?php echo e(__('translation.app-setting')); ?></span></a>
                                <a class="dropdown-item" href="<?php echo e(url('front-setting')); ?>"
                                ><span><?php echo e(__('translation.front-side')); ?></span></a>
                            </div>
                        </li>
                    <?php elseif($role == 'doctor'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('appointment.create')); ?>">
                                <i class="bx bx-calendar-plus me-2"></i><?php echo e(__('translation.appointments')); ?>

                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#!" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bx bxs-user-detail me-2"></i><?php echo e(__('translation.patients')); ?> <div
                                    class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="<?php echo e(url('patient')); ?>"
                                    class="dropdown-item"><?php echo e(__('translation.list-of-patients')); ?></a>
                                <a href="<?php echo e(route('patient.create')); ?>"
                                    class="dropdown-item"><?php echo e(__('translation.add-new-patient')); ?></a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="<?php echo e(url('receptionist')); ?>">
                                <i class="bx bx-user-voice me-2"></i><?php echo e(__('translation.receptionist')); ?>

                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="<?php echo e(url('accountant')); ?>">
                                <i class="bx bx-user-circle me-2"></i><?php echo e(__('translation.accountant')); ?>

                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#!" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bx bx-notepad me-2"></i><?php echo e(__('translation.prescription')); ?><div
                                    class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="<?php echo e(url('prescription')); ?>"
                                    class="dropdown-item"><?php echo e(__('translation.list-of-prescription')); ?></a>
                                <a href="<?php echo e(route('prescription.create')); ?>"
                                    class="dropdown-item"><?php echo e(__('translation.create-prescription')); ?></a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#!" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bx bx-receipt me-2"></i><?php echo e(__('translation.invoice')); ?> <div
                                    class="arrow-down">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="<?php echo e(url('invoice')); ?>"
                                    class="dropdown-item"><?php echo e(__('translation.list-of-invoice')); ?></a>
                                <a href="<?php echo e(route('invoice.create')); ?>"
                                    class="dropdown-item"><?php echo e(__('translation.create-invoice')); ?></a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('pending-appointment')); ?>">
                                <i class='bx bx-list-ul me-2'></i><?php echo e(__('translation.appointment-list')); ?>

                            </a>
                        </li>
                    <?php elseif($role == 'receptionist'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('appointment.create')); ?>">
                                <i class="bx bx-calendar-plus me-2"></i><?php echo e(__('translation.appointments')); ?>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('doctor')); ?>">
                                <i class="bx-plus-medical me-2"></i><?php echo e(__('translation.doctors')); ?>

                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#!" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bx bxs-user-detail me-2"></i><?php echo e(__('translation.patients')); ?> <div
                                    class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="<?php echo e(url('patient')); ?>"
                                    class="dropdown-item"><?php echo e(__('translation.list-of-patients')); ?></a>
                                <a href="<?php echo e(route('patient.create')); ?>"
                                    class="dropdown-item"><?php echo e(__('translation.add-new-patient')); ?></a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('prescription')); ?>">
                                <i class="bx bx-notepad me-2"></i><?php echo e(__('translation.prescription')); ?>

                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#!" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bx bx-receipt me-2"></i><?php echo e(__('translation.invoice')); ?><div
                                    class="arrow-down">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="<?php echo e(url('invoice')); ?>"
                                    class="dropdown-item"><?php echo e(__('translation.list-of-invoice')); ?></a>
                                <a href="<?php echo e(route('invoice.create')); ?>"
                                    class="dropdown-item"><?php echo e(__('translation.create-invoice')); ?></a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('pending-appointment')); ?>">
                                <i class='bx bx-list-plus me-2'></i><?php echo e(__('translation.appointment-list')); ?>

                            </a>
                        </li>
                    <?php elseif($role == 'patient'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('appointment.create')); ?>">
                                <i class="bx bx-calendar-plus me-2"></i><?php echo e(__('translation.appointments')); ?>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('doctor')); ?>">
                                <i class="bx-plus-medical me-2"></i><?php echo e(__('translation.doctors')); ?>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('prescription-list')); ?>">
                                <i class="bx bx-notepad me-2"></i><?php echo e(__('translation.prescription')); ?>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('invoice-list')); ?>">
                                <i class="bx bx-receipt me-2"></i><?php echo e(__('translation.invoice')); ?>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('patient-appointment')); ?>">
                                <i class='bx bx-list-ul me-2'></i><?php echo e(__('translation.appointment-list')); ?>

                            </a>
                        </li>
                    <?php elseif($role == 'accountant'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('doctor')); ?>">
                                <i class="bx-plus-medical me-2"></i><?php echo e(__('translation.doctors')); ?>

                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#!" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bx bx-receipt me-2"></i><?php echo e(__('translation.invoice')); ?> <div
                                    class="arrow-down">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="<?php echo e(url('invoice')); ?>"
                                    class="dropdown-item"><?php echo e(__('translation.list-of-invoice')); ?></a>
                                <a href="<?php echo e(route('invoice.create')); ?>"
                                    class="dropdown-item"><?php echo e(__('translation.create-invoice')); ?></a>
                            </div>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </div>
</div>
<?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views\layouts\hor-menu.blade.php ENDPATH**/ ?>
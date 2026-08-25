<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="<?php echo e(url('/dashboard')); ?>" class="logo logo-light">
                    <img src="<?php echo e(URL::asset('build/images/logo.png')); ?>" alt="CORE" height="34">
                </a>
            </div>
            <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light"
                data-bs-toggle="collapse" data-bs-target="#topnav-menu-content" id="toggle-button">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        </div>
        <div class="d-flex">
            <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-magnify"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-search-dropdown">
                    <form class="p-3">
                        <div class="mb-3 m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="<?php echo e(__('Search ...')); ?>"
                                    aria-label="Search input">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i
                                            class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <?php switch(Session::get('lang')):
                        case ('ru'): ?>
                            <img src="<?php echo e(URL::asset('/build/images/flags/russia.jpg')); ?>" alt="Header Language" height="16">
                        <?php break; ?>

                        <?php case ('it'): ?>
                            <img src="<?php echo e(URL::asset('/build/images/flags/italy.jpg')); ?>" alt="Header Language" height="16">
                        <?php break; ?>

                        <?php case ('sp'): ?>
                            <img src="<?php echo e(URL::asset('/build/images/flags/spain.jpg')); ?>" alt="Header Language" height="16">
                        <?php break; ?>

                        <?php case ('ch'): ?>
                            <img src="<?php echo e(URL::asset('/build/images/flags/china.svg')); ?>" alt="Header Language" height="16">
                        <?php break; ?>

                        <?php case ('fr'): ?>
                            <img src="<?php echo e(URL::asset('/build/images/flags/french.jpg')); ?>" alt="Header Language" height="16">
                        <?php break; ?>

                        <?php case ('gr'): ?>
                            <img src="<?php echo e(URL::asset('/build/images/flags/germany.jpg')); ?>" alt="Header Language" height="16">
                        <?php break; ?>

                        <?php case ('ae'): ?>
                            <img src="<?php echo e(URL::asset('/build/images/flags/ae.svg')); ?>" alt="Header Language" height="16">
                        <?php break; ?>

                        <?php default: ?>
                            <img src="<?php echo e(URL::asset('/build/images/flags/us.jpg')); ?>" alt="Header Language" height="16">
                    <?php endswitch; ?>
                </button>
                <div class="dropdown-menu dropdown-menu-end">

                    <!-- item-->
                    <a href="<?php echo e(url('index/en')); ?>" class="dropdown-item notify-item language py-2" data-lang="en"
                        title="English">
                        <img src="<?php echo e(URL::asset('build/images/flags/us.jpg')); ?>" alt="user-image"
                            class="me-2" height="12">
                        <span class="align-middle">English</span>
                    </a>

                    <!-- item-->
                    <a href="<?php echo e(url('index/sp')); ?>" class="dropdown-item notify-item language" data-lang="sp"
                        title="Spanish">
                        <img src="<?php echo e(URL::asset('build/images/flags/spain.jpg')); ?>" alt="user-image"
                            class="me-2" height="12">
                        <span class="align-middle">Española</span>
                    </a>

                    <!-- item-->
                    <a href="<?php echo e(url('index/gr')); ?>" class="dropdown-item notify-item language" data-lang="gr"
                        title="German">
                        <img src="<?php echo e(URL::asset('build/images/flags/germany.jpg')); ?>" alt="user-image"
                            class="me-2" height="12"> <span class="align-middle">Deutsche</span>
                    </a>

                    <!-- item-->
                    <a href="<?php echo e(url('index/it')); ?>" class="dropdown-item notify-item language" data-lang="it"
                        title="Italian">
                        <img src="<?php echo e(URL::asset('build/images/flags/italy.jpg')); ?>" alt="user-image"
                            class="me-2" height="12">
                        <span class="align-middle">Italiana</span>
                    </a>

                    <!-- item-->
                    <a href="<?php echo e(url('index/ru')); ?>" class="dropdown-item notify-item language" data-lang="ru"
                        title="Russian">
                        <img src="<?php echo e(URL::asset('build/images/flags/russia.jpg')); ?>" alt="user-image"
                            class="me-2" height="12">
                        <span class="align-middle">русский</span>
                    </a>

                    <!-- item-->
                    <a href="<?php echo e(url('index/ch')); ?>" class="dropdown-item notify-item language" data-lang="ch"
                        title="Chinese">
                        <img src="<?php echo e(URL::asset('build/images/flags/china.svg')); ?>" alt="user-image"
                            class="me-2" height="12">
                        <span class="align-middle">中国人</span>
                    </a>

                    <!-- item-->
                    <a href="<?php echo e(url('index/fr')); ?>" class="dropdown-item notify-item language" data-lang="fr"
                        title="French">
                        <img src="<?php echo e(URL::asset('build/images/flags/french.jpg')); ?>" alt="user-image"
                            class="me-2" height="12">
                        <span class="align-middle">français</span>
                    </a>
                    <!-- item-->
                    <a href="<?php echo e(url('index/ae')); ?>" class="dropdown-item notify-item language" data-lang="ae"
                        title="Arabic">
                        <img src="<?php echo e(URL::asset('build/images/flags/ae.svg')); ?>" alt="user-image"
                            class="me-2" height="18">
                        <span class="align-middle">Arabic</span>
                    </a>
                </div>
            </div>
            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                    <i class="bx bx-fullscreen"></i>
                </button>
            </div>
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect"
                    id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="bx bx-bell bx-tada"></i>
                    <span class="badge bg-danger rounded-pill"><?php echo e($Cnotification_count->count()); ?></span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0"> <?php echo e(__('Notifications')); ?></h6>
                            </div>
                            <div class="col-auto">
                                <a href="<?php echo e(url('/notification-list')); ?>" class="small"> <?php echo e(__('View All')); ?></a>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar class="notification-list-scroll overflow-auto" style="max-height: 230px;">
                        <?php $__empty_1 = true; $__currentLoopData = $Cnotification_count; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <a href="/notification/<?php echo e($item->id); ?>"
                                class="text-reset notification-item bg-light ">
                                <div class="d-flex">
                                    <img src="<?php if($user->profile_photo != ''): ?> <?php echo e(URL::asset('storage/images/users/' . $user->profile_photo)); ?><?php else: ?><?php echo e(URL::asset('build/images/users/noImage.png')); ?> <?php endif; ?>"
                                        class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                    <div class="flex-grow-1">
                                        <h6 class="mt-0 mb-1">
                                            <?php echo e($item->user->first_name . ' ' . $item->user->last_name); ?></h6>
                                        <div class="font-size-12 text-muted">
                                            <p class="mb-1"><?php echo e($item->title); ?></p>
                                            <p class="mb-0"><i class="mdi mdi-clock-outline"></i>
                                                <?php echo e($item->created_at->diffForHumans()); ?> </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="p-2 border-top d-grid">
                        <a class="btn btn-sm btn-link font-size-14 w-100 text-center"
                            href="<?php echo e(url('/notification-list')); ?>">
                            <i class="mdi mdi-arrow-right-circle me-1"></i> <?php echo e(__('View More..')); ?>

                        </a>
                    </div>
                </div>
            </div>
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user"
                        src="<?php if($user->profile_photo != ''): ?> <?php echo e(URL::asset('storage/images/users/' . $user->profile_photo)); ?><?php else: ?><?php echo e(URL::asset('build/images/users/noImage.png')); ?> <?php endif; ?>"
                        alt="Avatar">
                    <span class="d-none d-xl-inline-block ms-1"><?php echo e($user->first_name); ?></span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <?php if($role == 'doctor'): ?>
                        <a class="dropdown-item" href="<?php echo e(url('profile-view')); ?>"><i
                                class="bx bx-user font-size-16 align-middle me-1"></i>
                            <?php echo e(__('translation.profile')); ?></a>
                    <?php elseif($role == 'accountant'): ?>
                        <a class="dropdown-item" href="<?php echo e(url('profile-edit')); ?>"><i
                                class="bx bx-user font-size-16 align-middle me-1"></i>
                            <?php echo e(__('translation.profile')); ?></a>
                    <?php elseif($role == 'patient'): ?>
                        <a class="dropdown-item" href="<?php echo e(url('profile-view')); ?>"><i
                                class="bx bx-user font-size-16 align-middle me-1"></i>
                            <?php echo e(__('translation.profile')); ?></a>
                    <?php elseif($role == 'receptionist'): ?>
                        <a class="dropdown-item" href="<?php echo e(url('profile-view')); ?>"><i
                                class="bx bx-user font-size-16 align-middle me-1"></i>
                            <?php echo e(__('translation.profile')); ?></a>
                    <?php elseif($role == 'admin'): ?>
                        <a class="dropdown-item" href="<?php echo e(url('profile-edit')); ?>"><i
                                class="bx bx-user font-size-16 align-middle me-1"></i>
                            <?php echo e(__('translation.change-profile')); ?></a>
                        <a class="dropdown-item" href="<?php echo e(url('payment-key')); ?>"><i
                                class="bx bx-key font-size-16 align-middle me-1"></i>
                            <?php echo e(__('translation.add-api-key')); ?></a>
                        <a class="dropdown-item" href="<?php echo e(url('app-setting')); ?>"><i
                                class="bx bx-cog font-size-16 align-middle me-1"></i>
                            <?php echo e(__('translation.app-setting')); ?></a>
                    <?php endif; ?>
                    <a class="dropdown-item d-block" href="<?php echo e(url('change-password')); ?>"><i
                            class="bx bx-wrench font-size-16 align-middle me-1"></i>
                        <?php echo e(__('translation.change-password')); ?></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="javascript:void();"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                            class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
                        <?php echo e(__('translation.logout')); ?> </a>
                    <form id="logout-form" action="<?php echo e(url('logout')); ?>" method="POST" style="display: none;">
                        <?php echo csrf_field(); ?>
                    </form>
                </div>
            </div>
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect ">
                    <i class="bx bx-cog bx-spin"></i>
                </button>
            </div>
        </div>
    </div>
</header>
<?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views\layouts\top-hor.blade.php ENDPATH**/ ?>
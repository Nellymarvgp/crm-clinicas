<?php $__env->startSection('title'); ?> <?php echo e(__("Reset Password")); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<style>
    :root {
        --core-sand: #d1cba4;
        --core-stone: #7c7c7b;
        --core-deep: #666665;
    }

    .bg-primary-subtle {
        background: rgba(209, 203, 164, 0.2) !important;
    }

    .text-primary,
    .text-primary h5,
    h5.text-primary {
        color: var(--core-stone) !important;
    }

    .auth-logo .avatar-title {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .auth-logo .avatar-title i {
        color: var(--core-stone);
        font-size: 30px;
    }

    .btn-primary {
        background: var(--core-stone) !important;
        border-color: var(--core-stone) !important;
        color: #fff !important;
    }

    .btn-primary:hover,
    .btn-primary:focus {
        background: var(--core-deep) !important;
        border-color: var(--core-deep) !important;
    }

    .form-control:focus {
        border-color: var(--core-sand) !important;
        box-shadow: 0 0 0 0.15rem rgba(209, 203, 164, 0.28) !important;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>
<body>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="home-btn d-none d-sm-block">
        <a href="<?php echo e(url('/dashboard')); ?>" class="text-dark"><i class="fas fa-home h2"></i></a>
    </div>
    <div class="account-pages my-5 pt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-primary-subtle">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary"><?php echo e(__("Reset Password")); ?></h5>
                                        <p>Restablece tu contraseña con <?php echo e(AppSetting('title')); ?>.</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="<?php echo e(URL::asset('build/images/servicio3.png')); ?>" alt="Odontologia" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="auth-logo">
                                <a href="<?php echo e(url('/dashboard')); ?>" class="auth-logo-light">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <i class="fas fa-tooth" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </a>
                                <a href="<?php echo e(url('/dashboard')); ?>" class="auth-logo-dark">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <i class="fas fa-tooth" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2">
                                <form class="form-horizontal" method="POST" action="<?php echo e(route('login')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <div class="mb-3">
                                        <label for="username"><?php echo e(__("Username")); ?></label>
                                        <input name="email" type="email"  class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            <?php if(old('email')): ?> value="<?php echo e(old('email')); ?>" <?php endif; ?> id="username" placeholder="<?php echo e(__("Enter username")); ?>"
                                            autocomplete="email" autofocus>
                                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="mb-3 row mb-0">
                                        <div class="col-12 text-end">
                                            <button class="btn btn-primary w-md waves-effect waves-light"
                                                type="submit"><?php echo e(__("Reset")); ?></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <p><?php echo e(__("Remember It?")); ?> <a href="<?php echo e(url('login')); ?>" class="fw-medium text-primary"> <?php echo e(__("Sign In here")); ?></a></p>
                        <p>© <?php echo e(date('Y')); ?> <?php echo e(AppSetting('title')); ?>. <?php echo e(__('por CORE')); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-without-nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views\auth\verify.blade.php ENDPATH**/ ?>
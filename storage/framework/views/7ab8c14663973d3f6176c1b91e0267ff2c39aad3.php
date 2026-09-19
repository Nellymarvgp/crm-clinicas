<?php $__env->startSection('title'); ?> <?php echo e(__("Iniciar Sesión")); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<style>
    :root {
        --core-sand: #d1cba4;
        --core-stone: #7c7c7b;
        --core-deep: #666665;
        --core-soft: #f6f3e8;
    }

    .block-left .card {
        background: var(--core-sand);
        margin-bottom: 0;
        border-radius: 0;
        height: 100%;
    }
    .account-pages .block-left .auth-logo .avatar-md.profile-user-wid {
        margin: 10px 0 !important;
        width: auto;
        height: auto;
    }
    .account-pages .block-left .auth-logo .avatar-md.profile-user-wid .avatar-title {
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent !important;
    }
    .account-pages .block-left .auth-logo .avatar-md.profile-user-wid .avatar-title i {
        font-size: 34px;
        color: var(--core-stone);
    }
    .account-pages .block-left .bg-light2 {
        background: #fff;
        margin: 20px;
        border: 1px solid rgba(124, 124, 123, 0.3);
        border-radius: 10px;
    }
    .account-pages .block-left .bg-light2 form button {
        background: var(--core-stone) !important;
        border: 1px solid var(--core-stone) !important;
        color: #fff !important;
    }
    .account-pages .block-left .bg-light2 form button:hover,
    .account-pages .block-left .bg-light2 form button:focus {
        background: var(--core-deep) !important;
        border-color: var(--core-deep) !important;
    }
    .account-pages .block-left .bg-light2 form .mt-4.text-center a.text-muted {
        margin-bottom: 20px;
        display: block;
        border-bottom: 1px solid #ccc;
        padding-bottom: 20px;
    }
    .account-pages .block-left .bg-light2 form .mt-4.text-center p {
        margin: 0;
    }
    .account-pages .block-left .bg-light2 form .mt-4.text-center p a.fw-medium.text-primary {
        color: var(--core-stone) !important;
        text-decoration: underline;
    }
    .account-pages .justify-content-center {
        display: flex;
        align-items: stretch;
        flex-direction: row;
    }
    .account-pages .block-left, .account-pages .block-right {
        padding: 0;
        min-height: 570px;
    }
    .account-pages .block-right img {
        height: 100%;
        width: 100%;
        object-fit: cover;
    }

    .account-pages label,
    .account-pages .form-check-label,
    .account-pages .text-muted,
    .account-pages p {
        color: var(--core-stone) !important;
    }

    .account-pages .form-control:focus {
        border-color: var(--core-sand);
        box-shadow: 0 0 0 0.2rem rgba(209, 203, 164, 0.25);
    }

    /* MediaQueries */
    @media only screen and (max-width: 768px) {
        .account-pages .justify-content-center{
            display: block;
        }
    }
    @media only screen and (max-width: 414px) {
        .account-pages {
            padding: 0 !important;
        }
        .block-right img {
            width: 100%;
            height: auto;
        }
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
<body>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="account-pages my-5 pt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-6 col-xs-12 block-left">
                    <div class="card overflow-hidden">
                        <div class="card-body pt-0">
                            <div class="auth-logo">
                                <a href="<?php echo e(url('/panel')); ?>" class="auth-logo-dark">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <i class="fas fa-tooth" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="p-5 bg-light2">
                                <form class="form-horizontal" method="POST" action="<?php echo e(url('login')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <?php if($msg = Session::get('error')): ?>
                                        <div class="alert alert-danger">
                                            <span> <?php echo e($msg); ?> </span>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($msg = Session::get('success')): ?>
                                        <div class="alert alert-success">
                                            <span> <?php echo e($msg); ?> </span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="mb-3">
                                        <label for="username"><?php echo e(__("Correo electrónico")); ?> <span class="text-danger">*</span></label>
                                        <input name="email" type="email" id="email"
                                            class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            <?php if(old('email')): ?> value="<?php echo e(old('email')); ?>" <?php endif; ?> id="username" placeholder="Ingrese su correo electrónico"
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
                                    <div class="mb-3">
                                        <label for="userpassword"><?php echo e(__("Contraseña")); ?> <span class="text-danger">*</span></label>
                                        <input type="password" name="password" id="pass"
                                            class="form-control  <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="userpassword" <?php if(old('password')): ?> value="<?php echo e(old('password')); ?>" <?php endif; ?> placeholder="Ingrese su contraseña">
                                        <?php $__errorArgs = ['password'];
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
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="remember"
                                            id="customControlInline">
                                        <label class="form-check-label" for="customControlInline">Recuérdame</label>
                                    </div>
                                    <div class="mt-3">
                                        <button class="btn btn-primary w-100 waves-effect waves-light"
                                            type="submit"><?php echo e(__("Iniciar Sesión")); ?></button>
                                    </div>
                                    <div class="mt-4 text-center">
                                        <a href="<?php echo e(url('forgot-password')); ?>" class="text-muted"><i
                                                class="mdi mdi-lock me-1"></i> <?php echo e(__("¿Olvidó su contraseña?")); ?></a>
                                                <p><?php echo e(__("¿No tiene una cuenta?")); ?> <a href="<?php echo e(url('register')); ?>"
                                class="fw-medium text-primary"> <?php echo e(__("Regístrese aquí")); ?></a> </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xs-12 block-right">
                    <img src="<?php echo e(URL::asset('build/images/fondo-od.jpg')); ?>" alt="Imagen odontologica" class="image-bg">
                </div>
            </div>
        </div>
    </div>
    <script>
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-without-nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views/auth/login.blade.php ENDPATH**/ ?>
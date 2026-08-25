<?php $__env->startSection('title'); ?> <?php echo e(__('Complete Profile')); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<style>
    .block-left .card {
        background: rgb(153 217 217);
        margin-bottom: 0;
        border-radius: 0;
        height: 100%;
        min-height: 570px; /* Ensure minimum height */
    }
    .account-pages .block-left .auth-logo .avatar-md.profile-user-wid {
        margin: 10px 0 !important;
        width: auto;
        height: auto;
    }
    .account-pages .block-left .auth-logo .avatar-md.profile-user-wid .avatar-title {
        display: block;
        background: transparent !important;
    }
    .account-pages .block-left .auth-logo .avatar-md.profile-user-wid .avatar-title img.rounded-circle {
        width: 50px;
        height: auto;
    }
    .account-pages .block-left .bg-light2 {
        background: #fff;
        margin: 20px;
        border: 1px solid #ccc;
        border-radius: 10px;
        padding: 2rem !important; /* Ensure padding matches register */
    }
    .account-pages .block-left .bg-light2 form button {
        background: rgb(153 217 217) !important;
        border: 1px solid rgb(153 217 217) !important;
        color: #fff; /* Ensure button text is visible */
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
    .form-control:focus {
        border-color: rgb(153 217 217) !important;
        box-shadow: 0 0 0 0.15rem rgba(153, 217, 217, 0.25) !important;
    }
    /* Profile photo specific styles */
    #profile_display {
        display: block;
        width: 150px;  /* Adjust size as needed */
        height: 150px; /* Adjust size as needed */
        margin: 10px auto;
        border-radius: 50%;
        object-fit: cover;
        cursor: pointer;
        border: 3px solid #ddd;
    }
    /* MediaQueries */
    @media only screen and (max-width: 768px) {
        .account-pages .justify-content-center{
            display: block;
        }
        .account-pages .block-right {
            min-height: 300px;
        }
        .account-pages .block-left .card {
             min-height: auto;
        }
        .account-pages .block-left, .account-pages .block-right {
            min-height: auto;
        }
    }
    @media only screen and (max-width: 414px) {
        .account-pages {
            padding: 0 !important;
        }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>
    <body>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="account-pages my-5 pt-5">
        <div class="container-fluid p-0"> <!-- Use container-fluid and remove padding -->
            <div class="row justify-content-center g-0"> <!-- Remove gutters -->
                <div class="col-md-6 col-lg-6 col-xs-12 block-left">
                    <div class="card overflow-hidden">
                        <div class="card-body pt-0">
                            <div class="auth-logo">
                                <a href="<?php echo e(url('/')); ?>" class="auth-logo-dark">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="<?php echo e(URL::asset('build/images/icon-plus.png')); ?>" alt="" class="rounded-circle" height="34">
                                        </span>
                                    </div>
                                </a>
                                <h5 class="text-center mt-0 text-white"><?php echo e(__('Complete su Perfil')); ?></h5>
                                <p class="text-center text-white">Complete su cuenta <?php echo e(AppSetting('title')); ?>.</p>
                            </div>
                            <div class="p-4 bg-light2">
                                <form method="POST" class="form-horizontal mt-4" action="<?php echo e(url('user')); ?>"
                                    enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <?php if($errors->any()): ?>
                                        <div class="alert alert-danger">
                                            <ul>
                                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li><?php echo e($error); ?></li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>

                                    <blockquote><?php echo e(__('Información Básica')); ?></blockquote>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label"><?php echo e(__('Edad ')); ?><span
                                                        class="text-danger">*</span></label>
                                                <input type="number" min="1"
                                                    class="form-control <?php $__errorArgs = ['age'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="age"
                                                    id="patientAge" value="<?php echo e(old('age')); ?>"
                                                    placeholder="<?php echo e(__('Ingrese su Edad')); ?>">
                                                <?php $__errorArgs = ['age'];
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
                                                <label for="formmessage"><?php echo e(__('Género ')); ?><span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select <?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="gender">
                                                    <option value="" disabled <?php echo e(old('gender') ? '' : 'selected'); ?>><?php echo e(__('-- Seleccione Género --')); ?></option>
                                                    <option value="Male" <?php echo e(old('gender') == 'Male' ? 'selected' : ''); ?>><?php echo e(__('Masculino')); ?></option>
                                                    <option value="Female" <?php echo e(old('gender') == 'Female' ? 'selected' : ''); ?>><?php echo e(__('Femenino')); ?></option>
                                                    <option value="Other" <?php echo e(old('gender') == 'Other' ? 'selected' : ''); ?>><?php echo e(__('Otro')); ?></option>
                                                </select>
                                                <?php $__errorArgs = ['gender'];
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
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label"><?php echo e(__('Foto de Perfil ')); ?><span
                                                        class="text-danger">*</span></label>
                                                <img class="<?php $__errorArgs = ['profile_photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    src="<?php echo e(URL::asset('build/images/users/noImage.png')); ?>"
                                                    id="profile_display" onclick="triggerClick()" data-bs-toggle="tooltip"
                                                    data-placement="top" title="Click para subir foto de perfil" />
                                                <input type="file"
                                                    class="form-control <?php $__errorArgs = ['profile_photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    name="profile_photo" id="profile_photo" style="display:none;"
                                                    onchange="displayProfile(this)" accept="image/*">
                                                <?php $__errorArgs = ['profile_photo'];
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
                                        </div>
                                    </div>
                                    <div class="row">
                                         <div class="col-md-12 mb-3">
                                            <label class="form-label"><?php echo e(__('Dirección Actual ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <textarea id="formmessage" name="address"
                                                class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                 rows="3"
                                                placeholder="<?php echo e(__('Ingrese su Dirección Actual')); ?>"><?php echo e(old('address')); ?></textarea>
                                            <?php $__errorArgs = ['address'];
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
                                    </div>

                                    <blockquote><?php echo e(__('Información Médica')); ?></blockquote>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label"><?php echo e(__('Altura (cm)')); ?><span class="text-danger">*</span></label>
                                                <input type="number" min="1" step="1"
                                                    class="form-control <?php $__errorArgs = ['height'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="height"
                                                    value="<?php echo e(old('height')); ?>"
                                                    placeholder="<?php echo e(__('Ingrese su altura en centímetros')); ?>">
                                                <?php $__errorArgs = ['height'];
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
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label"><?php echo e(__('Peso (kg)')); ?><span class="text-danger">*</span></label>
                                                <input type="number" min="1" step="0.1"
                                                    class="form-control <?php $__errorArgs = ['weight'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="weight"
                                                    value="<?php echo e(old('weight')); ?>"
                                                    placeholder="<?php echo e(__('Ingrese su peso en kilogramos')); ?>">
                                                <?php $__errorArgs = ['weight'];
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
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label"><?php echo e(__('Grupo Sanguíneo')); ?><span class="text-danger">*</span></label>
                                                <select class="form-select <?php $__errorArgs = ['b_group'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="b_group">
                                                    <option value="" disabled <?php echo e(old('b_group') ? '' : 'selected'); ?>><?php echo e(__('-- Seleccione Grupo --')); ?></option>
                                                    <option value="A+" <?php echo e(old('b_group') == 'A+' ? 'selected' : ''); ?>>A+</option>
                                                    <option value="A-" <?php echo e(old('b_group') == 'A-' ? 'selected' : ''); ?>>A-</option>
                                                    <option value="B+" <?php echo e(old('b_group') == 'B+' ? 'selected' : ''); ?>>B+</option>
                                                    <option value="B-" <?php echo e(old('b_group') == 'B-' ? 'selected' : ''); ?>>B-</option>
                                                    <option value="O+" <?php echo e(old('b_group') == 'O+' ? 'selected' : ''); ?>>O+</option>
                                                    <option value="O-" <?php echo e(old('b_group') == 'O-' ? 'selected' : ''); ?>>O-</option>
                                                    <option value="AB+" <?php echo e(old('b_group') == 'AB+' ? 'selected' : ''); ?>>AB+</option>
                                                    <option value="AB-" <?php echo e(old('b_group') == 'AB-' ? 'selected' : ''); ?>>AB-</option>
                                                </select>
                                                <?php $__errorArgs = ['b_group'];
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
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label"><?php echo e(__('Pulso (bpm)')); ?><span class="text-danger">*</span></label>
                                                <input type="number" min="1"
                                                    class="form-control <?php $__errorArgs = ['pulse'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="pulse"
                                                    value="<?php echo e(old('pulse')); ?>"
                                                    placeholder="<?php echo e(__('Ingrese su pulso')); ?>">
                                                <?php $__errorArgs = ['pulse'];
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
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label"><?php echo e(__('Presión Arterial (mmHg)')); ?><span class="text-danger">*</span></label>
                                                <input type="number" min="1"
                                                    class="form-control <?php $__errorArgs = ['b_pressure'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="b_pressure"
                                                    value="<?php echo e(old('b_pressure')); ?>"
                                                    placeholder="<?php echo e(__('Ingrese su presión arterial')); ?>">
                                                <?php $__errorArgs = ['b_pressure'];
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
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label"><?php echo e(__('Respiración (rpm)')); ?><span class="text-danger">*</span></label>
                                                <input type="number" min="1"
                                                    class="form-control <?php $__errorArgs = ['respiration'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="respiration"
                                                    value="<?php echo e(old('respiration')); ?>"
                                                    placeholder="<?php echo e(__('Ingrese su frecuencia respiratoria')); ?>">
                                                <?php $__errorArgs = ['respiration'];
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
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label"><?php echo e(__('Alergias')); ?><span class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control <?php $__errorArgs = ['allergy'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="allergy"
                                                    value="<?php echo e(old('allergy')); ?>"
                                                    placeholder="<?php echo e(__('Ingrese sus alergias (solo letras)')); ?>">
                                                <?php $__errorArgs = ['allergy'];
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
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label"><?php echo e(__('Dieta')); ?><span class="text-danger">*</span></label>
                                                <textarea
                                                    class="form-control <?php $__errorArgs = ['diet'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="diet"
                                                    rows="3"
                                                    placeholder="<?php echo e(__('Describa su dieta actual')); ?>"><?php echo e(old('diet')); ?></textarea>
                                                <?php $__errorArgs = ['diet'];
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
                                        </div>
                                    </div>
                                    <blockquote><?php echo e(__('Antecedentes Médicos')); ?></blockquote>
                                    <p class="text-muted mb-2"><?php echo e(__('Todos los campos de antecedentes médicos son opcionales.')); ?></p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label"><?php echo e(__('Diabetes')); ?><span class="text-danger">*</span></label>
                                                <select class="form-select <?php $__errorArgs = ['diabetes_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="diabetes_status">
                                                    <option value="" disabled <?php echo e(old('diabetes_status') ? '' : 'selected'); ?>><?php echo e(__('-- Seleccione --')); ?></option>
                                                    <option value="si" <?php echo e(old('diabetes_status') == 'si' ? 'selected' : ''); ?>>Si</option>
                                                    <option value="no" <?php echo e(old('diabetes_status') == 'no' ? 'selected' : ''); ?>>No</option>
                                                </select>
                                                <?php $__errorArgs = ['diabetes_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label"><?php echo e(__('Diabetes controlado (si/no)')); ?></label>
                                                <select class="form-select <?php $__errorArgs = ['diabetes_controlled'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="diabetes_controlled">
                                                    <option value="" selected><?php echo e(__('-- Seleccione --')); ?></option>
                                                    <option value="si" <?php echo e(old('diabetes_controlled') == 'si' ? 'selected' : ''); ?>>Si</option>
                                                    <option value="no" <?php echo e(old('diabetes_controlled') == 'no' ? 'selected' : ''); ?>>No</option>
                                                </select>
                                                <?php $__errorArgs = ['diabetes_controlled'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label"><?php echo e(__('Hipertensión')); ?><span class="text-danger">*</span></label>
                                                <select class="form-select <?php $__errorArgs = ['hypertension_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="hypertension_status">
                                                    <option value="" disabled <?php echo e(old('hypertension_status') ? '' : 'selected'); ?>><?php echo e(__('-- Seleccione --')); ?></option>
                                                    <option value="si" <?php echo e(old('hypertension_status') == 'si' ? 'selected' : ''); ?>>Si</option>
                                                    <option value="no" <?php echo e(old('hypertension_status') == 'no' ? 'selected' : ''); ?>>No</option>
                                                </select>
                                                <?php $__errorArgs = ['hypertension_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label"><?php echo e(__('Hipertensión controlado (si/no)')); ?></label>
                                                <select class="form-select <?php $__errorArgs = ['hypertension_controlled'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="hypertension_controlled">
                                                    <option value="" selected><?php echo e(__('-- Seleccione --')); ?></option>
                                                    <option value="si" <?php echo e(old('hypertension_controlled') == 'si' ? 'selected' : ''); ?>>Si</option>
                                                    <option value="no" <?php echo e(old('hypertension_controlled') == 'no' ? 'selected' : ''); ?>>No</option>
                                                </select>
                                                <?php $__errorArgs = ['hypertension_controlled'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label"><?php echo e(__('Actualmente embarazada')); ?><span class="text-danger">*</span></label>
                                                <select class="form-select <?php $__errorArgs = ['currently_pregnant'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="currently_pregnant">
                                                    <option value="" disabled <?php echo e(old('currently_pregnant') ? '' : 'selected'); ?>><?php echo e(__('-- Seleccione --')); ?></option>
                                                    <option value="si" <?php echo e(old('currently_pregnant') == 'si' ? 'selected' : ''); ?>>Si</option>
                                                    <option value="no" <?php echo e(old('currently_pregnant') == 'no' ? 'selected' : ''); ?>>No</option>
                                                </select>
                                                <?php $__errorArgs = ['currently_pregnant'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label"><?php echo e(__('Infarto')); ?><span class="text-danger">*</span></label>
                                                <select class="form-select <?php $__errorArgs = ['heart_attack_history'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="heart_attack_history">
                                                    <option value="" disabled <?php echo e(old('heart_attack_history') ? '' : 'selected'); ?>><?php echo e(__('-- Seleccione --')); ?></option>
                                                    <option value="si" <?php echo e(old('heart_attack_history') == 'si' ? 'selected' : ''); ?>>Si</option>
                                                    <option value="no" <?php echo e(old('heart_attack_history') == 'no' ? 'selected' : ''); ?>>No</option>
                                                </select>
                                                <?php $__errorArgs = ['heart_attack_history'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label"><?php echo e(__('¿Cuándo fue el último infarto?')); ?></label>
                                                <input type="text" class="form-control <?php $__errorArgs = ['last_heart_attack'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    name="last_heart_attack" value="<?php echo e(old('last_heart_attack')); ?>" placeholder="<?php echo e(__('Ej: hace 2 años')); ?>">
                                                <?php $__errorArgs = ['last_heart_attack'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label"><?php echo e(__('Actualmente consume medicamentos')); ?><span class="text-danger">*</span></label>
                                                <select class="form-select <?php $__errorArgs = ['takes_medications'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="takes_medications">
                                                    <option value="" disabled <?php echo e(old('takes_medications') ? '' : 'selected'); ?>><?php echo e(__('-- Seleccione --')); ?></option>
                                                    <option value="si" <?php echo e(old('takes_medications') == 'si' ? 'selected' : ''); ?>>Si</option>
                                                    <option value="no" <?php echo e(old('takes_medications') == 'no' ? 'selected' : ''); ?>>No</option>
                                                </select>
                                                <?php $__errorArgs = ['takes_medications'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label"><?php echo e(__('¿Cuál medicamentos?')); ?></label>
                                                <input type="text" class="form-control <?php $__errorArgs = ['medications_list'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    name="medications_list" value="<?php echo e(old('medications_list')); ?>" placeholder="<?php echo e(__('Describa los medicamentos')); ?>">
                                                <?php $__errorArgs = ['medications_list'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label"><?php echo e(__('Aspirina en las últimas 72 horas')); ?><span class="text-danger">*</span></label>
                                                <select class="form-select <?php $__errorArgs = ['aspirin_last_72h'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="aspirin_last_72h">
                                                    <option value="" disabled <?php echo e(old('aspirin_last_72h') ? '' : 'selected'); ?>><?php echo e(__('-- Seleccione --')); ?></option>
                                                    <option value="si" <?php echo e(old('aspirin_last_72h') == 'si' ? 'selected' : ''); ?>>Si</option>
                                                    <option value="no" <?php echo e(old('aspirin_last_72h') == 'no' ? 'selected' : ''); ?>>No</option>
                                                </select>
                                                <?php $__errorArgs = ['aspirin_last_72h'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label"><?php echo e(__('Padece alguna enfermedad')); ?><span class="text-danger">*</span></label>
                                                <select class="form-select <?php $__errorArgs = ['has_disease'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="has_disease">
                                                    <option value="" disabled <?php echo e(old('has_disease') ? '' : 'selected'); ?>><?php echo e(__('-- Seleccione --')); ?></option>
                                                    <option value="si" <?php echo e(old('has_disease') == 'si' ? 'selected' : ''); ?>>Si</option>
                                                    <option value="no" <?php echo e(old('has_disease') == 'no' ? 'selected' : ''); ?>>No</option>
                                                </select>
                                                <?php $__errorArgs = ['has_disease'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label"><?php echo e(__('¿Cuál?')); ?></label>
                                                <input type="text" class="form-control <?php $__errorArgs = ['disease_details'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    name="disease_details" value="<?php echo e(old('disease_details')); ?>" placeholder="<?php echo e(__('Describa la enfermedad')); ?>">
                                                <?php $__errorArgs = ['disease_details'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-center mt-4">
                                            <button type="submit"
                                                class="btn btn-primary w-md waves-effect waves-light"><?php echo e(__('Guardar Perfil')); ?></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xs-12 block-right d-none d-md-block"> <!-- Hide on small screens -->
                     <img src="<?php echo e(URL::asset('build/images/fondo-bg.png')); ?>" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var fieldsToHide = ['height', 'b_group', 'pulse', 'allergy', 'weight', 'b_pressure', 'respiration', 'diet'];

            fieldsToHide.forEach(function(fieldName) {
                var field = document.querySelector('[name="' + fieldName + '"]');
                if (field) {
                    field.disabled = true;
                    var wrapper = field.closest('.mb-3');
                    if (wrapper) {
                        wrapper.style.display = 'none';
                    }
                }
            });

            var blockquotes = document.querySelectorAll('blockquote');
            blockquotes.forEach(function(bq) {
                if (bq.textContent.trim() === 'Información Médica') {
                    bq.style.display = 'none';
                }
            });
        });

        // Profile Photo Preview
        function triggerClick() {
            document.querySelector('#profile_photo').click();
        }

        function displayProfile(e) {
            if (e.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('#profile_display').setAttribute('src', e.target.result);
                }
                reader.readAsDataURL(e.files[0]);
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-without-nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views\profile-details.blade.php ENDPATH**/ ?>
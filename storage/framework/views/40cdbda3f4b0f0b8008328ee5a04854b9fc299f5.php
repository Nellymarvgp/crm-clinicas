<?php $__env->startSection('title'); ?>
    <?php echo e(__('Actualizar datos del doctor')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(URL::asset('build/libs/select2/css/select2.min.css')); ?>">
<?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">
                        <?php echo e(__('Actualizar datos del doctor')); ?>

                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo e(url('/dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo e(url('doctor')); ?>"><?php echo e(__('Doctores')); ?></a></li>
                            <li class="breadcrumb-item active">
                                <?php echo e(__('Actualizar datos del doctor')); ?>

                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <?php if($doctor && $doctor_info): ?>
                    <?php if($role == 'doctor'): ?>
                        <a href="<?php echo e(url('/dashboard')); ?>">
                            <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                                <i
                                    class="bx bx-arrow-back font-size-16 align-middle me-2"></i><?php echo e(__('Volver al panel')); ?>

                            </button>
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(url('doctor/' . $doctor->id)); ?>">
                            <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                                <i
                                    class="bx bx-arrow-back font-size-16 align-middle me-2"></i><?php echo e(__('Volver al perfil')); ?>

                            </button>
                        </a>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="<?php echo e(url('doctor')); ?>">
                        <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                            <i
                                class="bx bx-arrow-back font-size-16 align-middle me-2"></i><?php echo e(__('Volver a la lista de doctores')); ?>

                        </button>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <blockquote><?php echo e(__('Informacion basica')); ?></blockquote>
                        <form action="<?php echo e(url('doctor/' . $doctor->id)); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php if($doctor && $doctor_info): ?>
                                <input type="hidden" name="_method" value="PATCH" />
                            <?php endif; ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                                <label class="form-label"><?php echo e(__('Nombre ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="first_name" id="firstname" tabindex="1"
                                                value="<?php echo e(old('first_name', $doctor->first_name)); ?>"
                                                placeholder="<?php echo e(__('Ingrese el nombre')); ?>">
                                            <?php $__errorArgs = ['first_name'];
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
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                                <label class="form-label"><?php echo e(__('Correo electronico ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="email" id="email" tabindex="3"
                                                value="<?php echo e(old('email', $doctor->email)); ?>"
                                                placeholder="<?php echo e(__('Ingrese el correo electronico')); ?>">
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
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                                <label class="form-label"><?php echo e(__('Titulo profesional ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="title" id="title" tabindex="5"
                                                value="<?php echo e(old('title', $doctor_info->title)); ?>"
                                                placeholder="<?php echo e(__('Ingrese el titulo profesional')); ?>">
                                            <?php $__errorArgs = ['title'];
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
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                                <label class="form-label"><?php echo e(__('Especialidades')); ?><span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control select2 <?php $__errorArgs = ['departments'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="departments[]" id="department" multiple>
                                                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($department->id); ?>"
                                                    <?php echo e(in_array($department->id, old('departments', $selectedDepartmentIds ?? [])) ? 'selected' : ''); ?>>
                                                    <?php echo e($department->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <?php $__errorArgs = ['departments'];
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
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                                <label class="form-label"><?php echo e(__('Experiencia ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control <?php $__errorArgs = ['experience'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="experience" tabindex="7" id="experience"
                                                value="<?php echo e(old('experience', $doctor_info->experience)); ?>"
                                                placeholder="<?php echo e(__('Ingrese la experiencia')); ?>">
                                            <?php $__errorArgs = ['experience'];
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
                                    <div class="row">
                                        <?php if($availableDay): ?>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label d-block"><?php echo e(__('Dias de atencion del doctor')); ?> <span
                                                        class="text-danger">*</span></label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1"
                                                        value="1" name="sun" <?php echo e($availableDay->sun == 1 ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="inlineCheckbox1">Dom</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2"
                                                        value="1" name="mon" <?php echo e($availableDay->mon == 1 ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="inlineCheckbox2">Lun</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox3"
                                                        value="1" name="tue" <?php echo e($availableDay->tue == 1 ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="inlineCheckbox3">Mar</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox4"
                                                        value="1" name="wen" <?php echo e($availableDay->wen == 1 ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="inlineCheckbox4">Mie</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox5"
                                                        value="1" name="thu" <?php echo e($availableDay->thu == 1 ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="inlineCheckbox5">Jue</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox6"
                                                        value="1" name="fri" <?php echo e($availableDay->fri == 1 ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="inlineCheckbox6">Vie</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox7"
                                                        value="1" name="sat" <?php echo e($availableDay->sat == 1 ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="inlineCheckbox7">Sab</label>
                                                </div>
                                                <?php $__errorArgs = ['mon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="error d-block " role="alert">
                                                        <strong>Seleccione al menos un dia</strong>
                                                    </span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php if($availableTime && $availableTime->count() > 0): ?>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label d-block">Rangos de horario actuales</label>
                                                <div class="border rounded p-2 bg-light">
                                                    <?php $__currentLoopData = $availableTime; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $timeRange): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="small text-muted"><?php echo e(\Carbon\Carbon::parse($timeRange->from)->format('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse($timeRange->to)->format('H:i')); ?></div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                                <small class="form-text text-muted">Para modificar los rangos de horas use el boton "Editar horarios".</small>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <a href="<?php echo e(url('time-edit/' . $doctor->id)); ?>" class="btn btn-outline-primary">Editar horarios</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                                <label class="form-label"><?php echo e(__('Apellido ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="last_name" id="lastname" tabindex="2"
                                                value="<?php echo e(old('last_name', $doctor->last_name)); ?>"
                                                placeholder="<?php echo e(__('Ingrese el apellido')); ?>">
                                            <?php $__errorArgs = ['last_name'];
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
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                                <label class="form-label"><?php echo e(__('Telefono ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input type="tel" class="form-control <?php $__errorArgs = ['mobile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="mobile" id="patientMobile" tabindex="4"
                                                value="<?php echo e(old('mobile', $doctor->mobile)); ?>"
                                                placeholder="<?php echo e(__('Ingrese el telefono')); ?>">
                                            <?php $__errorArgs = ['mobile'];
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
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                                <label class="form-label"><?php echo e(__('Titulacion ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control <?php $__errorArgs = ['degree'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="degree" id="degree" tabindex="6"
                                                value="<?php echo e(old('degree', $doctor_info->degree)); ?>"
                                                placeholder="<?php echo e(__('Ingrese la titulacion')); ?>">
                                            <?php $__errorArgs = ['degree'];
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
                                    <input type="hidden" name="fees" value="<?php echo e(old('fees', $doctor_info->fees ?? 0)); ?>">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                                <label class="form-label"><?php echo e(__('% Pago Doctor ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input type="number" step="0.01" min="0" max="100"
                                                class="form-control <?php $__errorArgs = ['doctor_payment_percentage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="doctor_payment_percentage" id="doctor_payment_percentage"
                                                value="<?php echo e(old('doctor_payment_percentage', $doctor_info->doctor_payment_percentage)); ?>"
                                                placeholder="<?php echo e(__('Ingrese porcentaje de pago')); ?>">
                                            <?php $__errorArgs = ['doctor_payment_percentage'];
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
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label"><?php echo e(__('Foto de perfil ')); ?></label>
                                            <img class="<?php $__errorArgs = ['profile_photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                src=" <?php if($doctor && $doctor_info &&
                                                $doctor->profile_photo != null): ?>
                                            <?php echo e(URL::asset('storage/images/users/' . $doctor->profile_photo)); ?>

                                        <?php else: ?> <?php echo e(URL::asset('build/images/users/noImage.png')); ?> <?php endif; ?>"
                                            id="profile_display" onclick="triggerClick()"
                                            data-bs-toggle="tooltip" data-placement="top"
                                            title="Haga clic para cargar la foto de perfil" />
                                            <input type="file"
                                                class="form-control <?php $__errorArgs = ['profile_photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                tabindex="8" name="profile_photo" id="profile_photo" style="display:none;"
                                                onchange="displayProfile(this)">
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
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        <?php if($doctor && $doctor_info): ?>
                                            <?php echo e(__('Actualizar datos')); ?>

                                        <?php else: ?>
                                            <?php echo e(__('Crear doctor')); ?>

                                        <?php endif; ?>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script'); ?>
        <script src="<?php echo e(URL::asset('build/libs/jquery-repeater/jquery-repeater.min.js')); ?>"></script>
        <!-- form init -->
        <script src="<?php echo e(URL::asset('build/js/pages/form-repeater.int.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('build/libs/select2/js/select2.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('build/js/pages/form-advanced.init.js')); ?>"></script>
        <script>
            // Profile Photo
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
            // Checkbox value check
            $('#inlineCheckbox1').on('change', function() {
                var inlineCheckbox1 = $('#inlineCheckbox1').is(':checked') ? '1' : '0';
                $('#inlineCheckbox1').val(inlineCheckbox1);
            }).change();
            $('#inlineCheckbox2').on('change', function() {
                var inlineCheckbox2 = $('#inlineCheckbox2').is(':checked') ? '1' : '0';
                $('#inlineCheckbox2').val(inlineCheckbox2);
            }).change();
            $('#inlineCheckbox3').on('change', function() {
                var inlineCheckbox3 = $('#inlineCheckbox3').is(':checked') ? '1' : '0';
                $('#inlineCheckbox3').val(inlineCheckbox3);
            }).change();
            $('#inlineCheckbox4').on('change', function() {
                var inlineCheckbox4 = $('#inlineCheckbox4').is(':checked') ? '1' : '0';
                $('#inlineCheckbox4').val(inlineCheckbox4);
            }).change();
            $('#inlineCheckbox5').on('change', function() {
                var inlineCheckbox5 = $('#inlineCheckbox5').is(':checked') ? '1' : '0';
                $('#inlineCheckbox5').val(inlineCheckbox5);
            }).change();
            $('#inlineCheckbox6').on('change', function() {
                var inlineCheckbox6 = $('#inlineCheckbox6').is(':checked') ? '1' : '0';
                $('#inlineCheckbox6').val(inlineCheckbox6);
            }).change();
            $('#inlineCheckbox7').on('change', function() {
                var inlineCheckbox7 = $('#inlineCheckbox7').is(':checked') ? '1' : '0';
                $('#inlineCheckbox7').val(inlineCheckbox7);
            }).change();
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views/doctor/doctor-edit.blade.php ENDPATH**/ ?>
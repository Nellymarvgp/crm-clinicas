<?php $__env->startSection('title'); ?>
    <?php echo e(__('Update prescription')); ?>

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
                        <?php echo e(__('Update prescription')); ?>

                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo e(url('/dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo e(url('prescription')); ?>"><?php echo e(__('Prescription')); ?></a>
                            </li>
                            <li class="breadcrumb-item active">
                                <?php echo e(__('Update prescription')); ?>

                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <blockquote><?php echo e(__('Prescription Details')); ?></blockquote>
                        <form class="outer-repeater" action="<?php echo e(url('prescription/' . '' . $prescription->id)); ?>"
                            method="post">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="_method" value="PATCH" />
                            <input type="hidden" name="id" value="<?php echo e($prescription->id); ?>" id="form_id" />

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><?php echo e(__('Patient ')); ?><span
                                            class="text-danger">*</span></label>
                                    <select
                                        class="form-control select2 sel_patient <?php $__errorArgs = ['patient_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        name="patient_id" id="patient">
                                        <option disabled selected><?php echo e(__('Select Patient')); ?></option>
                                        <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($patient->id); ?>"
                                                <?php echo e($patient->id == $prescription->patient->id ? 'selected' : ''); ?>>
                                                <?php echo e($patient->first_name); ?> <?php echo e($patient->last_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['patient_id'];
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
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><?php echo e(__('Appointment :')); ?><span
                                            class="text-danger">*</span></label>
                                    <select
                                        class="form-control select2 sel_appointment <?php $__errorArgs = ['appointment_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        name="appointment_id" id="appointment">
                                        <option disabled selected><?php echo e(__('Select Appointment')); ?></option>
                                        <?php $__currentLoopData = $appointment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($item->id); ?>"
                                                <?php echo e($item->id == $prescription->appointment->id ? 'selected' : ''); ?>>
                                                <?php echo e($item->appointment_date); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['appointment_id'];
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
                                <input type="hidden" name="created_by" value="<?php echo e($user->id); ?>">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><?php echo e(__('Symptoms ')); ?><span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control <?php $__errorArgs = ['symptoms'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="symptoms"
                                        id="symptoms" placeholder="<?php echo e(__('Add Symptoms')); ?>"
                                        rows="3"><?php if(old('symptoms')): ?><?php echo e(old('symptoms')); ?><?php endif; ?> <?php echo e($prescription->symptoms); ?></textarea>
                                    <?php $__errorArgs = ['symptoms'];
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
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><?php echo e(__('Diagnosis ')); ?><span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control <?php $__errorArgs = ['diagnosis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="diagnosis"
                                        id="diagnosis" placeholder="<?php echo e(__('Add Diagnosis')); ?>"
                                        rows="3"><?php if(old('diagnosis')): ?><?php echo e(old('diagnosis')); ?><?php endif; ?><?php echo e($prescription->diagnosis); ?></textarea>
                                    <?php $__errorArgs = ['diagnosis'];
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
                            <blockquote><?php echo e(__('Medication & Test Reports Details')); ?></blockquote>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class='repeater mb-4'>
                                        <div data-repeater-list="medicines" class="mb-3">
                                            <label><?php echo e(__('Medicines ')); ?><span class="text-danger">*</span></label>
                                            <?php $__currentLoopData = $medicines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div data-repeater-item class="mb-3 row">
                                                    <div class="col-md-5 col-6">
                                                        <input type="text" name="medicine" class="form-control"
                                                            placeholder="<?php echo e(__('Medicine Name')); ?>"
                                                            value="<?php echo e($item->name); ?>" />
                                                    </div>
                                                    <div class="col-md-5 col-6">
                                                        <textarea type="text" name="notes" class="form-control"
                                                            placeholder="<?php echo e(__('Notes...')); ?>"><?php echo e($item->notes); ?></textarea>
                                                    </div>
                                                    <div class="col-md-2 col-4">
                                                        <input data-repeater-delete type="button"
                                                            class="fcbtn btn btn-outline btn-danger btn-1d btn-sm inner"
                                                            value="X" />
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                        <input data-repeater-create type="button" class="btn btn-primary"
                                            value="Add Medicine" />
                                    </div>
                                </div>
                                <?php if($test_reports->count() == 0): ?>
                                    <div class="col-md-6">
                                        <div class='repeater mb-4'>
                                            <div data-repeater-list="test_reports" class="mb-3">
                                                <label><?php echo e(__('Test Reports ')); ?><span
                                                        class="text-danger">*</span></label>
                                                <div data-repeater-item class="mb-3 row">
                                                    <div class="col-md-5 col-6">
                                                        <input type="text" name="test_report" class="form-control"
                                                            placeholder="<?php echo e(__('Test Report Name')); ?>" />
                                                    </div>
                                                    <div class="col-md-5 col-6">
                                                        <textarea type="text" name="notes" class="form-control"
                                                            placeholder="<?php echo e(__('Notes...')); ?>"></textarea>
                                                    </div>
                                                    <div class="col-md-2 col-4">
                                                        <input data-repeater-delete type="button"
                                                            class="fcbtn btn btn-outline btn-danger btn-1d btn-sm inner"
                                                            value="X" />
                                                    </div>
                                                </div>
                                            </div>
                                            <input data-repeater-create type="button" class="btn btn-primary"
                                                value="Add Test Report" />
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="col-md-6">
                                        <div class='repeater mb-4'>
                                            <div data-repeater-list="test_reports" class="mb-3">
                                                <label><?php echo e(__('Test Reports ')); ?><span
                                                        class="text-danger">*</span></label>
                                                <?php $__currentLoopData = $test_reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div data-repeater-item class="mb-3 row">
                                                        <div class="col-md-5 col-6">
                                                            <input type="text" name="test_report" class="form-control"
                                                                placeholder="<?php echo e(__('Test Report Name')); ?>"
                                                                value="<?php echo e($item->name); ?>" />
                                                        </div>
                                                        <div class="col-md-5 col-6">
                                                            <textarea type="text" name="notes" class="form-control"
                                                                placeholder="<?php echo e(__('Notes...')); ?>"><?php echo e($item->notes); ?></textarea>
                                                        </div>
                                                        <div class="col-md-2 col-4">
                                                            <input data-repeater-delete type="button"
                                                                class="fcbtn btn btn-outline btn-danger btn-1d btn-sm inner"
                                                                value="X" />
                                                        </div>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                            <input data-repeater-create type="button" class="btn btn-primary"
                                                value="Add Test Report" />
                                        </div>
                                    </div>
                                <?php endif; ?>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        <?php echo e(__('Update Prescription')); ?>

                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script'); ?>
        <script src="<?php echo e(URL::asset('build/libs/select2/js/select2.min.js')); ?>"></script>
        <!-- form mask -->
        <script src="<?php echo e(URL::asset('build/libs/jquery-repeater/jquery-repeater.min.js')); ?>"></script>
        <!-- form init -->
        <script src="<?php echo e(URL::asset('build/js/pages/form-repeater.int.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('build/js/pages/form-advanced.init.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('build/js/pages/notification.init.js')); ?>"></script>
        <script>
            $('.sel_patient').change(function(e) {
                e.preventDefault();
                $('.sel_appointment').empty();
                var patientId = $(this).val();
                var token = $("input[name='_token']").val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo e(route('patient_by_appointment')); ?>",
                    data: {
                        patient_id: patientId,
                        _token: token,
                    },
                    success: function(res) {
                        $('.sel_appointment').html('');
                        $('.sel_appointment').html(res.options);
                    },
                    error: function(res) {
                        console.log(res);
                    }
                });
            });
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views\prescription\prescription-edit.blade.php ENDPATH**/ ?>
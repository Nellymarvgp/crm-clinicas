<?php $__env->startSection('title'); ?>
    <?php if($department): ?>
        <?php echo e(__('Update Department Details')); ?>

    <?php else: ?>
        <?php echo e(__('Add New Department')); ?>

    <?php endif; ?>
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
                    <?php if($department): ?>
                        <?php echo e(__('Update Department Details')); ?>

                    <?php else: ?>
                        <?php echo e(__('Add New Department')); ?>

                    <?php endif; ?>
                </h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo e(url('/dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(url('department')); ?>"><?php echo e(__('Departments')); ?></a>
                        </li>
                        <li class="breadcrumb-item active">
                            <?php if($department): ?>
                                <?php echo e(__('Update Department Details')); ?>

                            <?php else: ?>
                                <?php echo e(__('Add New Department')); ?>

                            <?php endif; ?>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <?php if($department): ?>
                <?php if($role == 'department'): ?>
                    <a href="<?php echo e(url('/dashboard')); ?>">
                        <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                            <i class="bx bx-arrow-back font-size-16 align-middle me-2"></i><?php echo e(__('Back to Dashboard')); ?>

                        </button>
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(url('department/' . $department->id)); ?>">
                        <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                            <i
                                class="bx bx-arrow-back font-size-16 align-middle me-2"></i><?php echo e(__('Back to Department Profile')); ?>

                        </button>
                    </a>
                <?php endif; ?>
            <?php else: ?>
                <a href="<?php echo e(url('department')); ?>">
                    <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                        <i class="bx bx-arrow-back font-size-16 align-middle me-2"></i><?php echo e(__('Back to Department List')); ?>

                    </button>
                </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <blockquote><?php echo e(__('Basic Information')); ?></blockquote>
                    <form
                        action="<?php if($department): ?> <?php echo e(url('department/' . $department->id)); ?> <?php else: ?> <?php echo e(route('department.store')); ?> <?php endif; ?>"
                        method="post" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php if($department): ?>
                            <input type="hidden" name="_method" value="PATCH" />
                        <?php endif; ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="department-name" class="form-label"><?php echo e(__('Department Name ')); ?><span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            tabindex="1" name="name" id="department-name"
                                            value="<?php if($department): ?> <?php echo e($department->name); ?><?php elseif(old('name')): ?><?php echo e(old('name')); ?> <?php endif; ?>"
                                            placeholder="<?php echo e(__('Enter Department Name')); ?>">
                                        <?php $__errorArgs = ['name'];
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
                                    <div class="col-md-12 mb-3">
                                        <label for="department-description"
                                            class="form-label"><?php echo e(__('Description ')); ?><span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" tabindex="1"
                                            name="description" id="department-description"
                                            value="<?php if($department): ?> <?php echo e($department->description); ?><?php elseif(old('description')): ?><?php echo e(old('description')); ?> <?php endif; ?>"
                                            placeholder="<?php echo e(__('Max Description 250 caracters')); ?>">
                                        <?php $__errorArgs = ['description'];
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
                                    <?php if($department): ?>
                                        <?php echo e(__('Update Details')); ?>

                                    <?php else: ?>
                                        <?php echo e(__('Add New Department')); ?>

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
    <script src="<?php echo e(URL::asset('build/libs/select2/js/select2.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/pages/form-advanced.init.js')); ?>"></script>
    
    <script>
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
        // Multipale Select
        $(".select2").select2({
            tags: true,
            tokenSeparators: [',', ' ']
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views\department\department-details.blade.php ENDPATH**/ ?>
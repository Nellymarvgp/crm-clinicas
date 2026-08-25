<?php $__env->startSection('title'); ?> <?php echo e(__("419 Page Expired")); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
<body>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="account-pages my-5 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mb-5">
                        <h1 class="display-2 fw-medium">419</h1>
                        <h4 class="text-uppercase"><?php echo e(__("Page Expired")); ?></h4>
                        <div class="mt-5 text-center">
                            <a class="btn btn-primary waves-effect waves-light" href="<?php echo e(url('/dashboard')); ?>"><?php echo e(__("Back to Dashboard")); ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8 col-xl-6">
                    <div>
                        <img src="<?php echo e(URL::asset('build/images/error-img.png')); ?>" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-without-nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views\error\419.blade.php ENDPATH**/ ?>

<?php $__env->startSection('title'); ?>
    <?php echo e(__('Front Setting')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <!-- start page title -->
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('title'); ?>
            Front Setting
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('li_1'); ?>
            Dashboard
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('li_2'); ?>
            Setting
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('li_3'); ?>
            Front Setting
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <blockquote>Enable/Disable Views</blockquote>

                    <div class="table-responsive">
                        <table class="table table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td><?php echo e($section->title); ?></td>
                                        <td>
                                            <?php if($section->is_enable == 0): ?>
                                                <span class="badge bg-success">Enable</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning">Disable</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($section->is_enable == 0): ?>
                                                <a href="<?php echo e(route('section.disable', ['id' => $section->id])); ?>"
                                                    class="btn btn-sm btn-warning">Disable</a>
                                            <?php else: ?>
                                                <a href="<?php echo e(route('section.enable', ['id' => $section->id])); ?>"
                                                    class="btn btn-sm btn-success">Enable</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views\landing\manage.blade.php ENDPATH**/ ?>
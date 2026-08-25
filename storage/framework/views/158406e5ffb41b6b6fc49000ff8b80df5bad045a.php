<option selected value="">--- Seleccione una cita ---</option>
<?php if(!empty($appointment)): ?>
    <?php $__currentLoopData = $appointment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views\appointment\ajax-select-appointment.blade.php ENDPATH**/ ?>
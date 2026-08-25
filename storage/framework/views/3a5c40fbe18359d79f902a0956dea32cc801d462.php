<?php $__env->startSection('title', 'Solicitar Llamada'); ?>

<?php $__env->startSection('css'); ?>
<style>
    .call-form-container {
        max-width: 550px;
        margin: 0 auto;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        background-color: #fff;
    }
    
    .call-form-heading {
        color: #4FB1B1;
        text-align: center;
        margin-bottom: 30px;
    }
    
    .btn-success {
        background-color: #4FB1B1 !important;
        border-color: #4FB1B1 !important;
    }
    
    .btn-success:hover {
        background-color: #429a9a !important;
        border-color: #429a9a !important;
    }
    
    .form-control:focus {
        border-color: #4FB1B1;
        box-shadow: 0 0 0 0.2rem rgba(79, 177, 177, 0.25);
    }
    
    .call-form-banner {
        text-align: center;
        margin-bottom: 20px;
    }
    
    .call-form-banner i {
        font-size: 64px;
        color: #4FB1B1;
    }
    
    .call-form-wrapper {
        padding-top: 70px;
        padding-bottom: 70px;
    }
    
    .required::after {
        content: " *";
        color: red;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="call-form-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="call-form-container">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo e(session('success')); ?>

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo e(session('error')); ?>

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <div class="call-form-banner">
                        <i class="mdi mdi-phone-in-talk-outline"></i>
                    </div>
                    
                    <h2 class="call-form-heading">Solicitar Llamada</h2>
                    <p class="text-center mb-4">Complete el formulario y un agente se comunicará con usted a la brevedad</p>
                    
                    <form method="POST" action="<?php echo e(route('request-call.process')); ?>" id="call-form">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="name" class="required">Nombre completo</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="name" name="name" value="<?php echo e(old('name')); ?>" required>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone" class="required">Teléfono</label>
                            <input type="tel" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="phone" name="phone" value="<?php echo e(old('phone')); ?>" placeholder="Ej. +1234567890" required>
                            <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <?php if(count($agents) > 1): ?>
                        <div class="form-group">
                            <label for="agent_id" class="required">Departamento</label>
                            <select class="form-control <?php $__errorArgs = ['agent_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="agent_id" name="agent_id" required>
                                <option value="">Seleccione un departamento</option>
                                <?php $__currentLoopData = $agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($agent->id); ?>" <?php echo e(old('agent_id') == $agent->id ? 'selected' : ''); ?>><?php echo e($agent->agent_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['agent_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <?php else: ?>
                            <input type="hidden" name="agent_id" value="<?php echo e($agents->first()->id ?? ''); ?>">
                        <?php endif; ?>
                        
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-success btn-block">Solicitar Llamada</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script>
    $(document).ready(function() {
        // Validación simple del número de teléfono
        $('#call-form').on('submit', function(e) {
            const phoneInput = $('#phone');
            const phoneValue = phoneInput.val().trim();
            
            // Validación básica: al menos 10 caracteres
            if (phoneValue.length < 10) {
                e.preventDefault();
                phoneInput.addClass('is-invalid');
                if (!phoneInput.next('.invalid-feedback').length) {
                    phoneInput.after('<div class="invalid-feedback">El número de teléfono debe tener al menos 10 dígitos</div>');
                }
                return false;
            }
            
            return true;
        });
        
        // Limpiar validación al cambiar el valor
        $('#phone').on('input', function() {
            $(this).removeClass('is-invalid');
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-landing', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views\public\call\form.blade.php ENDPATH**/ ?>
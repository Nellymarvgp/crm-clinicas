<?php $__env->startSection('title'); ?> Editar Configuración de Llamada <?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <style>
        .btn-success {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
        }
        .btn-success:hover, .btn-success:focus, .btn-success:active {
            background-color: #218838 !important;
            border-color: #1e7e34 !important;
        }
        .custom-control-input:checked ~ .custom-control-label::before {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
        }
        .add-param-btn {
            color: #28a745;
            border-color: #28a745;
        }
        .add-param-btn:hover {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
        }
        .remove-param-btn {
            color: #dc3545;
            cursor: pointer;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('title'); ?> Editar Configuración de Llamada <?php $__env->endSlot(); ?>
        <?php $__env->slot('li_1'); ?> Admin <?php $__env->endSlot(); ?>
        <?php $__env->slot('li_2'); ?> Configuraciones <?php $__env->endSlot(); ?>
        <?php $__env->slot('li_3'); ?> Llamadas <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo e(session('error')); ?>

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('setting-call.update', $callSetting->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="agent_name">Nombre del Agente <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['agent_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="agent_name" name="agent_name" value="<?php echo e(old('agent_name', $callSetting->agent_name)); ?>" required>
                                    <?php $__errorArgs = ['agent_name'];
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
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="agent_id">ID del Agente <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['agent_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="agent_id" name="agent_id" value="<?php echo e(old('agent_id', $callSetting->agent_id)); ?>" required>
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
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="call_url">URL de Llamada <span class="text-danger">*</span></label>
                            <input type="url" class="form-control <?php $__errorArgs = ['call_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="call_url" name="call_url" value="<?php echo e(old('call_url', $callSetting->call_url)); ?>" placeholder="https://ejemplo.com/api/call" required>
                            <?php $__errorArgs = ['call_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <small class="form-text text-muted">URL a la que se enviarán las solicitudes de llamada</small>
                        </div>

                        <div class="form-group">
                            <label>Parámetros (clave-valor)</label>
                            <div id="parameters-container">
                                <?php if(old('parameters')): ?>
                                    <?php $__currentLoopData = old('parameters'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $param): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="row param-row mb-2">
                                            <div class="col-md-5">
                                                <input type="text" class="form-control <?php $__errorArgs = ['parameters.'.$index.'.key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="parameters[<?php echo e($index); ?>][key]" placeholder="Clave" value="<?php echo e($param['key'] ?? ''); ?>">
                                                <?php $__errorArgs = ['parameters.'.$index.'.key'];
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
                                            <div class="col-md-5">
                                                <input type="text" class="form-control <?php $__errorArgs = ['parameters.'.$index.'.value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="parameters[<?php echo e($index); ?>][value]" placeholder="Valor" value="<?php echo e($param['value'] ?? ''); ?>">
                                                <?php $__errorArgs = ['parameters.'.$index.'.value'];
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
                                            <div class="col-md-2">
                                                <i class="mdi mdi-close-circle remove-param-btn align-middle" style="font-size: 24px;"></i>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php elseif($callSetting->parameters): ?>
                                    <?php $__currentLoopData = $callSetting->parameters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="row param-row mb-2">
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" name="parameters[<?php echo e($loop->index); ?>][key]" placeholder="Clave" value="<?php echo e($key); ?>">
                                            </div>
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" name="parameters[<?php echo e($loop->index); ?>][value]" placeholder="Valor" value="<?php echo e($value); ?>">
                                            </div>
                                            <div class="col-md-2">
                                                <i class="mdi mdi-close-circle remove-param-btn align-middle" style="font-size: 24px;"></i>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <!-- Fila inicial vacía -->
                                    <div class="row param-row mb-2">
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="parameters[0][key]" placeholder="Clave">
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="parameters[0][value]" placeholder="Valor">
                                        </div>
                                        <div class="col-md-2">
                                            <i class="mdi mdi-close-circle remove-param-btn align-middle" style="font-size: 24px;"></i>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <button type="button" id="add-param-btn" class="btn btn-outline-success btn-sm add-param-btn mt-2">
                                <i class="mdi mdi-plus"></i> Agregar Parámetro
                            </button>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" <?php echo e($callSetting->is_active ? 'checked' : ''); ?>>
                                <label class="custom-control-label" for="is_active">Activo</label>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-success mr-2">Actualizar</button>
                            <a href="<?php echo e(route('setting-call.index')); ?>" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        $(document).ready(function() {
            // Agregar parámetro
            $('#add-param-btn').on('click', function() {
                const index = $('.param-row').length;
                const newRow = `
                    <div class="row param-row mb-2">
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="parameters[${index}][key]" placeholder="Clave">
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="parameters[${index}][value]" placeholder="Valor">
                        </div>
                        <div class="col-md-2">
                            <i class="mdi mdi-close-circle remove-param-btn align-middle" style="font-size: 24px;"></i>
                        </div>
                    </div>
                `;
                $('#parameters-container').append(newRow);
            });
            
            // Eliminar parámetro
            $(document).on('click', '.remove-param-btn', function() {
                if ($('.param-row').length > 1) {
                    $(this).closest('.param-row').remove();
                } else {
                    // Si es la última fila, solo limpiar los campos
                    $(this).closest('.param-row').find('input').val('');
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views\call-setting\edit.blade.php ENDPATH**/ ?>
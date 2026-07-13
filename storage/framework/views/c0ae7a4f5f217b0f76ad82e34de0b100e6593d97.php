
<?php $__env->startSection('title'); ?>
    <?php echo e(__('App Setting')); ?>

<?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <!-- start page title -->
        <?php $__env->startComponent('components.breadcrumb'); ?>
            <?php $__env->slot('title'); ?>
                Configuración de CORE
            <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_1'); ?>
                Dashboard
            <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_2'); ?>
                Configuración
            <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_3'); ?>
                CORE
            <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <blockquote><?php echo e(__('Instrucciones de configuración')); ?></blockquote>

                        <div class="row">
                            <div class="col-lg-2">
                                <div class="card border border-primary">
                                    <img class="card-img-top img-fluid" src="<?php echo e(URL::asset('build/images/settings/title.png')); ?>" alt="Card image cap">
                                    <div class="card-body">
                                        <h4 class="card-title mb-2">Nombre de la app</h4>
                                        <p class="card-text">Se muestra en la cabecera y en los títulos del sistema.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="card border border-primary">
                                    <img class="card-img-top img-fluid" src="<?php echo e(URL::asset('build/images/settings/logo-sm.png')); ?>" alt="Card image cap">
                                    <div class="card-body">
                                        <h4 class="card-title mb-2">Logo pequeño</h4>
                                        <p class="card-text">Se muestra en pantallas móviles y vistas compactas.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="card border border-primary">
                                    <img class="card-img-top img-fluid" src="<?php echo e(URL::asset('build/images/settings/logo-lg.png')); ?>" alt="Card image cap">
                                    <div class="card-body">
                                        <h4 class="card-title mb-2">Logo grande</h4>
                                        <p class="card-text">Se muestra en las vistas principales del sistema.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="card border border-primary">
                                    <img class="card-img-top img-fluid" src="<?php echo e(URL::asset('build/images/settings/logo-sm-dark.png')); ?>" alt="Card image cap">
                                    <div class="card-body">
                                        <h4 class="card-title mb-2">Logo oscuro pequeño</h4>
                                        <p class="card-text">Se usa cuando la barra superior es clara en móvil.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="card border border-primary">
                                    <img class="card-img-top img-fluid" src="<?php echo e(URL::asset('build/images/settings/logo-lg-dark.png')); ?>" alt="Card image cap">
                                    <div class="card-body">
                                        <h4 class="card-title mb-2">Logo oscuro grande</h4>
                                        <p class="card-text">Se usa cuando la barra superior es clara.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="card border border-primary">
                                    <img class="card-img-top img-fluid" src="<?php echo e(URL::asset('build/images/settings/favicon.png')); ?>" alt="Card image cap">
                                    <div class="card-body">
                                        <h4 class="card-title mb-2">Favicon</h4>
                                        <p class="card-text">Se muestra junto al título de la página.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <blockquote><?php echo e(__('Setting Details')); ?></blockquote>
                        <form action="<?php echo e(route('update-setting')); ?>" method="post" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="appTitle">Nombre de la app <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="appTitle" value="<?php echo e(@$data->title); ?>" name="title">
                                        <small id="appTitleHelp" class="form-text text-muted">Ingrese entre 5 y 40 caracteres.</small>
                                        <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="text-danger"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="appLogo">Logo pequeño</label>
                                        <input type="file" class="form-control" data-allow-reorder="true" data-max-file-size="2MB" data-max-files="1" value="" name="logo_sm">
                                        <small class="form-text text-muted">Solo jpg, png o svg. Tamaño recomendado: 64x75.</small>
                                        <?php $__errorArgs = ['logo_sm'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="text-danger"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="appLogo">Logo grande</label>
                                        <input type="file" class="form-control" data-allow-reorder="true" data-max-file-size="2MB" data-max-files="1" value="" name="logo_lg">
                                        <small class="form-text text-muted">Solo jpg, png o svg. Tamaño recomendado: 440x75.</small>
                                        <?php $__errorArgs = ['logo_lg'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="text-danger"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="appLogo">Logo oscuro pequeño</label>
                                        <input type="file" class="form-control" data-allow-reorder="true" data-max-file-size="2MB" data-max-files="1" value="" name="logo_dark_sm">
                                        <small class="form-text text-muted">Solo jpg, png o svg. Tamaño recomendado: 64x75.</small>
                                        <?php $__errorArgs = ['logo_dark_sm'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="text-danger"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="appLogo">Logo oscuro grande</label>
                                        <input type="file" class="form-control" data-allow-reorder="true" data-max-file-size="2MB" data-max-files="1" value="" name="logo_dark_lg">
                                        <small class="form-text text-muted">Solo jpg, png o svg. Tamaño recomendado: 440x75.</small>
                                        <?php $__errorArgs = ['logo_dark_lg'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="text-danger"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="appFavicon">Favicon</label>
                                        <input type="file" class="form-control" id="appFavicon" data-allow-reorder="true" data-max-file-size="2MB" data-max-files="1" name="favicon">
                                        <small class="form-text text-muted">Solo jpg, png, svg o ico. Tamaño recomendado: 128x128.</small>
                                        <?php $__errorArgs = ['favicon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="text-danger"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                            <blockquote><?php echo e(__('Datos del pie de página')); ?></blockquote>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="footerLeft">Pie izquierdo <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="footerLeft" name="footer_left" value="<?php echo e(@$data->footer_left); ?>">
                                        <small class="form-text text-muted">Ingrese entre 5 y 40 caracteres.</small>
                                        <?php $__errorArgs = ['footer_left'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="text-danger"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="footerRight">Pie derecho <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="footerRight" name="footer_right" value="<?php echo e(@$data->footer_right); ?>">
                                        <small class="form-text text-muted">Ingrese entre 5 y 80 caracteres.</small>
                                        <?php $__errorArgs = ['footer_right'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="text-danger"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views/setting/setting.blade.php ENDPATH**/ ?>
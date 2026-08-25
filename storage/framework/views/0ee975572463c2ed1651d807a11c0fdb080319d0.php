
<?php $__env->startSection('title'); ?> <?php echo e(__('Detalle de Cita')); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php
    $dentalEvaluation = $appointment->dentalEvaluation;
    $canEditDentalEvaluation = in_array($role, ['doctor', 'admin', 'receptionist']);
    $toothMarks = $dentalEvaluation && is_array($dentalEvaluation->tooth_marks) ? $dentalEvaluation->tooth_marks : [];
    $upperTeeth = [18, 17, 16, 15, 14, 13, 12, 11, 21, 22, 23, 24, 25, 26, 27, 28];
    $lowerTeeth = [48, 47, 46, 45, 44, 43, 42, 41, 31, 32, 33, 34, 35, 36, 37, 38];
?>
<?php $__env->startSection('css'); ?>
<style>
    .odontogram-grid { display: grid; grid-template-columns: repeat(16, minmax(42px, 1fr)); gap: 8px; }
    .tooth-mark { border: 2px solid #ced4da; background: #fff; color: #495057; border-radius: 6px; min-height: 58px; font-weight: 600; }
    .tooth-mark.affected { background: #dc3545; border-color: #dc3545; color: #fff; }
    .tooth-mark.worked { background: #0d6efd; border-color: #0d6efd; color: #fff; }
    @media (max-width: 767px) { .odontogram-grid { overflow-x: auto; grid-template-columns: repeat(16, 48px); padding-bottom: 8px; } }
</style>
<?php $__env->stopSection(); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('title'); ?> Detalle de Cita <?php $__env->endSlot(); ?>
        <?php $__env->slot('li_1'); ?> Panel <?php $__env->endSlot(); ?>
        <?php $__env->slot('li_2'); ?> Citas <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row mb-3">
        <div class="col-12">
            <a href="<?php echo e(url()->previous()); ?>" class="btn btn-primary">
                <i class="mdi mdi-arrow-left me-1"></i><?php echo e(__('Volver')); ?>

            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4"><?php echo e(__('Información de la Cita')); ?></h4>
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <tbody>
                                <tr>
                                    <th style="width: 280px;"><?php echo e(__('ID de Cita')); ?></th>
                                    <td><?php echo e($appointment->id); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo e(__('Paciente')); ?></th>
                                    <td><?php echo e(optional($appointment->patient)->first_name); ?> <?php echo e(optional($appointment->patient)->last_name); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo e(__('Odontólogo')); ?></th>
                                    <td><?php echo e(optional(optional($appointment->doctor)->user)->first_name); ?> <?php echo e(optional(optional($appointment->doctor)->user)->last_name); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo e(__('Fecha')); ?></th>
                                    <td><?php echo e($appointment->appointment_date); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo e(__('Hora')); ?></th>
                                    <td>
                                        <?php if(optional($appointment->timeSlot)->from): ?>
                                            <?php echo e(\Carbon\Carbon::parse(optional($appointment->timeSlot)->from)->format('H:i')); ?> a <?php echo e(\Carbon\Carbon::parse(optional($appointment->timeSlot)->to)->format('H:i')); ?>

                                        <?php else: ?>
                                            <?php echo e(__('Sin horario')); ?>

                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo e(__('Estado')); ?></th>
                                    <td>
                                        <?php if((int) $appointment->status === 1): ?>
                                            <span class="badge badge-pill text-white" style="background-color:#198754;"><?php echo e(__('Completada')); ?></span>
                                        <?php elseif((int) $appointment->status === 2): ?>
                                            <span class="badge badge-pill text-white" style="background-color:#dc3545;"><?php echo e(__('Cancelada')); ?></span>
                                        <?php else: ?>
                                            <span class="badge badge-pill text-white" style="background-color:#0dcaf0;"><?php echo e(__('Pendiente')); ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo e(__('Monto Final')); ?></th>
                                    <td>
                                        <?php if(!is_null($appointment->final_consultation_price)): ?>
                                            $<?php echo e(number_format((float) $appointment->final_consultation_price, 2, '.', ',')); ?>

                                        <?php else: ?>
                                            <?php echo e(__('No definido')); ?>

                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo e(__('Creada por')); ?></th>
                                    <td><?php echo e(optional($appointment->BookedBy)->first_name); ?> <?php echo e(optional($appointment->BookedBy)->last_name); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="dental-history">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-2"><?php echo e(__('Historia Dental y Evaluación')); ?></h4>
                    <p class="text-muted"><?php echo e(__('Rojo: zona afectada. Azul: zona trabajada o restaurada.')); ?></p>
                    <?php if($canEditDentalEvaluation): ?>
                        <form method="POST" action="<?php echo e(route('appointment.dental-evaluation.save', $appointment->id)); ?>" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><?php echo e(__('Diagnóstico')); ?></label>
                                    <textarea name="diagnosis" class="form-control" rows="4" maxlength="5000"><?php echo e(old('diagnosis', optional($dentalEvaluation)->diagnosis)); ?></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><?php echo e(__('Tratamiento realizado')); ?></label>
                                    <textarea name="treatment" class="form-control" rows="4" maxlength="5000"><?php echo e(old('treatment', optional($dentalEvaluation)->treatment)); ?></textarea>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label"><?php echo e(__('Cantidad')); ?></label>
                                    <input type="number" name="quantity" min="0" step="0.01" class="form-control" value="<?php echo e(old('quantity', optional($dentalEvaluation)->quantity)); ?>">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label"><?php echo e(__('Valor')); ?></label>
                                    <input type="number" name="value" min="0" step="0.01" class="form-control" value="<?php echo e(old('value', optional($dentalEvaluation)->value)); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><?php echo e(__('Notas clínicas / Historia de la cita')); ?></label>
                                    <textarea name="clinical_notes" class="form-control" rows="3" maxlength="10000"><?php echo e(old('clinical_notes', optional($dentalEvaluation)->clinical_notes)); ?></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><?php echo e(__('Fotos de placas')); ?></label>
                                    <input type="file" name="photos[]" class="form-control" accept="image/jpeg,image/png,image/webp" multiple>
                                    <small class="text-muted"><?php echo e(__('Puedes adjuntar hasta 10 imágenes de máximo 5 MB cada una.')); ?></small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label d-block"><?php echo e(__('Odontograma')); ?></label>
                                <div class="odontogram-grid mb-2">
                                    <?php $__currentLoopData = $upperTeeth; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tooth): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <button type="button" class="tooth-mark <?php echo e($toothMarks[$tooth] ?? ''); ?>" data-tooth="<?php echo e($tooth); ?>"><?php echo e($tooth); ?></button>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php $__currentLoopData = $lowerTeeth; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tooth): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <button type="button" class="tooth-mark <?php echo e($toothMarks[$tooth] ?? ''); ?>" data-tooth="<?php echo e($tooth); ?>"><?php echo e($tooth); ?></button>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                <div class="d-flex gap-3 small text-muted">
                                    <span><i class="fas fa-square text-danger me-1"></i><?php echo e(__('Afectado')); ?></span>
                                    <span><i class="fas fa-square text-primary me-1"></i><?php echo e(__('Trabajado')); ?></span>
                                </div>
                            </div>
                            <input type="hidden" name="tooth_marks" id="tooth_marks" value="<?php echo e(json_encode($toothMarks)); ?>">
                            <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save me-1"></i><?php echo e(__('Guardar Historia Dental')); ?></button>
                            <?php if($dentalEvaluation && $dentalEvaluation->images->isNotEmpty()): ?>
                                <div class="mt-4">
                                    <h6><?php echo e(__('Placas adjuntas')); ?></h6>
                                    <div class="row">
                                        <?php $__currentLoopData = $dentalEvaluation->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-sm-3 col-6 mb-3">
                                                <a href="<?php echo e(asset('storage/' . $image->path)); ?>" target="_blank" rel="noopener">
                                                    <img src="<?php echo e(asset('storage/' . $image->path)); ?>" alt="<?php echo e($image->original_name); ?>" class="img-fluid rounded border" style="height: 130px; width: 100%; object-fit: cover;">
                                                </a>
                                                <small class="d-block text-truncate" title="<?php echo e($image->original_name); ?>"><?php echo e($image->original_name); ?></small>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </form>
                    <?php else: ?>
                        <div class="row">
                            <div class="col-md-6"><strong><?php echo e(__('Diagnóstico')); ?></strong><p><?php echo e(optional($dentalEvaluation)->diagnosis ?: __('Sin registrar')); ?></p></div>
                            <div class="col-md-6"><strong><?php echo e(__('Tratamiento realizado')); ?></strong><p><?php echo e(optional($dentalEvaluation)->treatment ?: __('Sin registrar')); ?></p></div>
                            <div class="col-md-3"><strong><?php echo e(__('Cantidad')); ?></strong><p><?php echo e(optional($dentalEvaluation)->quantity ?: '0'); ?></p></div>
                            <div class="col-md-3"><strong><?php echo e(__('Valor')); ?></strong><p><?php echo e(optional($dentalEvaluation)->value !== null ? number_format($dentalEvaluation->value, 2) : '0.00'); ?></p></div>
                            <div class="col-12"><strong><?php echo e(__('Notas clínicas')); ?></strong><p><?php echo e(optional($dentalEvaluation)->clinical_notes ?: __('Sin registrar')); ?></p></div>
                        </div>
                        <div class="odontogram-grid">
                            <?php $__currentLoopData = array_merge($upperTeeth, $lowerTeeth); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tooth): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="tooth-mark <?php echo e($toothMarks[$tooth] ?? ''); ?> text-center pt-3"><?php echo e($tooth); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php if($dentalEvaluation && $dentalEvaluation->images->isNotEmpty()): ?>
                            <div class="mt-4">
                                <h6><?php echo e(__('Placas adjuntas')); ?></h6>
                                <div class="row">
                                    <?php $__currentLoopData = $dentalEvaluation->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-sm-3 col-6 mb-3">
                                            <a href="<?php echo e(asset('storage/' . $image->path)); ?>" target="_blank" rel="noopener"><img src="<?php echo e(asset('storage/' . $image->path)); ?>" alt="<?php echo e($image->original_name); ?>" class="img-fluid rounded border" style="height: 130px; width: 100%; object-fit: cover;"></a>
                                            <small class="d-block text-truncate"><?php echo e($image->original_name); ?></small>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script>
    document.querySelectorAll('.tooth-mark[data-tooth]').forEach(function (tooth) {
        tooth.addEventListener('click', function () {
            if (this.classList.contains('affected')) {
                this.classList.remove('affected');
                this.classList.add('worked');
            } else if (!this.classList.contains('worked')) {
                this.classList.add('affected');
            } else {
                this.classList.remove('worked');
            }

            const marks = {};
            document.querySelectorAll('.tooth-mark[data-tooth]').forEach(function (item) {
                if (item.classList.contains('affected')) marks[item.dataset.tooth] = 'affected';
                if (item.classList.contains('worked')) marks[item.dataset.tooth] = 'worked';
            });
            document.getElementById('tooth_marks').value = JSON.stringify(marks);
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views/appointment/appointment-view.blade.php ENDPATH**/ ?>

<?php $__env->startSection('title'); ?> <?php echo e(__('Detalle de Cita')); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php
    $dentalEvaluation = $appointment->dentalEvaluation;
    $evaluationSource = $dentalEvaluation ?: ($previousEvaluation ?? null);
    $diagnosisItems = $dentalEvaluation->diagnosis_items ?? ($previousEvaluation->diagnosis_items ?? []);
    $canEditDentalEvaluation = in_array($role, ['doctor', 'admin', 'receptionist']) && (int) $appointment->status !== 1;
    $toothMarks = $dentalEvaluation && is_array($dentalEvaluation->tooth_marks)
        ? $dentalEvaluation->tooth_marks
        : (($previousEvaluation && is_array($previousEvaluation->tooth_marks)) ? $previousEvaluation->tooth_marks : []);
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
                                        <?php echo e($appointment->time_range_label); ?>

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
                    <?php if(!$dentalEvaluation && $previousEvaluation): ?>
                        <div class="alert alert-info">Se cargó el último registro clínico del paciente como referencia. Guarda la cita para crear su propio registro.</div>
                    <?php endif; ?>
                    <?php if($canEditDentalEvaluation): ?>
                        <form method="POST" action="<?php echo e(route('appointment.dental-evaluation.save', $appointment->id)); ?>" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label"><?php echo e(__('Notas clínicas / Historia de la cita')); ?></label>
                                    <textarea name="clinical_notes" class="form-control" rows="3" maxlength="10000"><?php echo e(old('clinical_notes', optional($evaluationSource)->clinical_notes)); ?></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><?php echo e(__('Fotos de placas')); ?></label>
                                    <input type="file" name="photos[]" class="form-control" accept="image/jpeg,image/png,image/webp" multiple>
                                    <small class="text-muted"><?php echo e(__('Puedes adjuntar hasta 10 imágenes de máximo 5 MB cada una.')); ?></small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label mb-0"><?php echo e(__('Diagnósticos, tratamientos y valores')); ?></label>
                                    <button type="button" class="btn btn-outline-primary btn-sm" id="add-diagnosis"><i class="mdi mdi-plus me-1"></i><?php echo e(__('Agregar diagnóstico')); ?></button>
                                </div>
                                <div id="diagnosis-items">
                                    <?php $__empty_1 = true; $__currentLoopData = $diagnosisItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <div class="row diagnosis-row g-2 mb-2">
                                            <div class="col-md-3"><input name="diagnosis_items[<?php echo e($index); ?>][diagnosis]" class="form-control" placeholder="Diagnóstico" value="<?php echo e($item['diagnosis'] ?? ''); ?>"></div>
                                            <div class="col-md-3"><input name="diagnosis_items[<?php echo e($index); ?>][treatment]" class="form-control" placeholder="Tratamiento" value="<?php echo e($item['treatment'] ?? ''); ?>"></div>
                                            <div class="col-md-2"><input name="diagnosis_items[<?php echo e($index); ?>][quantity]" type="number" min="0" step="0.01" class="form-control item-quantity" placeholder="Cantidad" value="<?php echo e($item['quantity'] ?? 1); ?>"></div>
                                            <div class="col-md-2"><input name="diagnosis_items[<?php echo e($index); ?>][value]" type="number" min="0" step="0.01" class="form-control item-value" placeholder="Valor" value="<?php echo e($item['value'] ?? 0); ?>"></div>
                                            <div class="col-md-1"><input class="form-control item-subtotal" placeholder="Subtotal" value="<?php echo e(number_format((float) ($item['subtotal'] ?? 0), 2, '.', '')); ?>" readonly></div>
                                            <div class="col-md-1"><button type="button" class="btn btn-outline-danger remove-diagnosis" title="Eliminar"><i class="mdi mdi-delete"></i></button></div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <div class="row diagnosis-row g-2 mb-2">
                                            <div class="col-md-3"><input name="diagnosis_items[0][diagnosis]" class="form-control" placeholder="Diagnóstico"></div><div class="col-md-3"><input name="diagnosis_items[0][treatment]" class="form-control" placeholder="Tratamiento"></div><div class="col-md-2"><input name="diagnosis_items[0][quantity]" type="number" min="0" step="0.01" class="form-control item-quantity" placeholder="Cantidad" value="1"></div><div class="col-md-2"><input name="diagnosis_items[0][value]" type="number" min="0" step="0.01" class="form-control item-value" placeholder="Valor"></div><div class="col-md-1"><input class="form-control item-subtotal" placeholder="Subtotal" readonly></div><div class="col-md-1"><button type="button" class="btn btn-outline-danger remove-diagnosis" title="Eliminar"><i class="mdi mdi-delete"></i></button></div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="text-end fw-bold">Total: <span id="diagnosis-total"><?php echo e(number_format((float) ($appointment->final_consultation_price ?? 0), 2, '.', '')); ?></span></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label d-block"><?php echo e(__('Odontograma')); ?></label>
                                <div class="btn-group mb-2" role="group" aria-label="Modo del odontograma">
                                    <button type="button" class="btn btn-outline-danger odontogram-mode active" data-mode="affected">Marcar afectado</button>
                                    <button type="button" class="btn btn-outline-primary odontogram-mode" data-mode="worked">Marcar trabajado</button>
                                    <button type="button" class="btn btn-outline-secondary odontogram-mode" data-mode="erase">Borrar marca</button>
                                </div>
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
                            <?php if((int) $appointment->status !== 1): ?>
                                <button type="submit" name="complete" value="1" class="btn btn-success"><i class="mdi mdi-check-circle me-1"></i><?php echo e(__('Guardar y completar cita')); ?></button>
                            <?php endif; ?>
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
                        <div class="mb-3"><strong><?php echo e(__('Notas clínicas / Historia de la cita')); ?></strong><p><?php echo e(optional($dentalEvaluation)->clinical_notes ?: __('Sin registrar')); ?></p></div>
                        <?php if(!empty($diagnosisItems)): ?>
                            <div class="table-responsive mb-3">
                                <table class="table table-bordered align-middle">
                                    <thead><tr><th><?php echo e(__('Diagnóstico')); ?></th><th><?php echo e(__('Tratamiento')); ?></th><th><?php echo e(__('Cantidad')); ?></th><th><?php echo e(__('Valor')); ?></th><th><?php echo e(__('Subtotal')); ?></th></tr></thead>
                                    <tbody>
                                        <?php $__currentLoopData = $diagnosisItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr><td><?php echo e($item['diagnosis'] ?? ''); ?></td><td><?php echo e($item['treatment'] ?? ''); ?></td><td><?php echo e($item['quantity'] ?? 0); ?></td><td><?php echo e(number_format((float) ($item['value'] ?? 0), 2)); ?></td><td><?php echo e(number_format((float) ($item['subtotal'] ?? 0), 2)); ?></td></tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
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
                    <?php if($dentalEvaluation): ?>
                        <div class="mt-3 d-flex flex-wrap gap-2">
                            <form method="POST" action="<?php echo e(route('appointment.dental-evaluation.email', $appointment->id)); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-outline-secondary"><i class="mdi mdi-email-send me-1"></i><?php echo e(__('Enviar diagnóstico por correo')); ?></button>
                            </form>
                            <a href="<?php echo e(route('appointment.budget.view', $appointment->id)); ?>" class="btn btn-outline-primary" target="_blank" rel="noopener">
                                <i class="mdi mdi-file-document-outline me-1"></i><?php echo e(__('Descargar presupuesto final')); ?>

                            </a>
                            <a href="<?php echo e(route('appointment.budget.whatsapp', $appointment->id)); ?>" class="btn btn-success" target="_blank" rel="noopener">
                                <i class="mdi mdi-whatsapp me-1"></i><?php echo e(__('Enviar por WhatsApp')); ?>

                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script>
    let diagnosisIndex = <?php echo e(count($diagnosisItems) ?: 1); ?>;
    const diagnosisContainer = document.getElementById('diagnosis-items');
    function updateDiagnosisTotal() {
        let total = 0;
        diagnosisContainer.querySelectorAll('.diagnosis-row').forEach(function (row) {
            const quantity = parseFloat(row.querySelector('.item-quantity')?.value || 0);
            const value = parseFloat(row.querySelector('.item-value')?.value || 0);
            const subtotal = quantity * value;
            total += subtotal;
            row.querySelector('.item-subtotal').value = subtotal.toFixed(2);
        });
        document.getElementById('diagnosis-total').textContent = total.toFixed(2);
    }
    document.getElementById('add-diagnosis')?.addEventListener('click', function () {
        const row = diagnosisContainer.querySelector('.diagnosis-row').cloneNode(true);
        row.querySelectorAll('input').forEach(function (input) {
            input.value = input.classList.contains('item-quantity') ? '1' : '';
            if (input.classList.contains('item-subtotal')) input.value = '0.00';
            input.name = input.name.replace(/diagnosis_items\[\d+\]/, 'diagnosis_items[' + diagnosisIndex + ']');
        });
        diagnosisIndex++;
        diagnosisContainer.appendChild(row);
        updateDiagnosisTotal();
    });
    diagnosisContainer?.addEventListener('input', updateDiagnosisTotal);
    diagnosisContainer?.addEventListener('click', function (event) {
        const button = event.target.closest('.remove-diagnosis');
        if (button && diagnosisContainer.querySelectorAll('.diagnosis-row').length > 1) {
            button.closest('.diagnosis-row').remove();
            updateDiagnosisTotal();
        }
    });
    updateDiagnosisTotal();
    let odontogramMode = 'affected';
    document.querySelectorAll('.odontogram-mode').forEach(function (modeButton) {
        modeButton.addEventListener('click', function () {
            odontogramMode = this.dataset.mode;
            document.querySelectorAll('.odontogram-mode').forEach(function (button) {
                button.classList.remove('active');
            });
            this.classList.add('active');
        });
    });
    document.querySelectorAll('.tooth-mark[data-tooth]').forEach(function (tooth) {
        tooth.addEventListener('click', function () {
            this.classList.remove('affected', 'worked');
            if (odontogramMode !== 'erase') {
                this.classList.add(odontogramMode);
            } else {
                this.classList.remove('affected', 'worked');
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
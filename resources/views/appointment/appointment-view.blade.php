@extends('layouts.master-layouts')
@section('title') {{ __('Detalle de Cita') }} @endsection
@section('content')
@php
    $dentalEvaluation = $appointment->dentalEvaluation;
    $canEditDentalEvaluation = in_array($role, ['doctor', 'admin', 'receptionist']);
    $toothMarks = $dentalEvaluation && is_array($dentalEvaluation->tooth_marks) ? $dentalEvaluation->tooth_marks : [];
    $upperTeeth = [18, 17, 16, 15, 14, 13, 12, 11, 21, 22, 23, 24, 25, 26, 27, 28];
    $lowerTeeth = [48, 47, 46, 45, 44, 43, 42, 41, 31, 32, 33, 34, 35, 36, 37, 38];
@endphp
@section('css')
<style>
    .odontogram-grid { display: grid; grid-template-columns: repeat(16, minmax(42px, 1fr)); gap: 8px; }
    .tooth-mark { border: 2px solid #ced4da; background: #fff; color: #495057; border-radius: 6px; min-height: 58px; font-weight: 600; }
    .tooth-mark.affected { background: #dc3545; border-color: #dc3545; color: #fff; }
    .tooth-mark.worked { background: #0d6efd; border-color: #0d6efd; color: #fff; }
    @media (max-width: 767px) { .odontogram-grid { overflow-x: auto; grid-template-columns: repeat(16, 48px); padding-bottom: 8px; } }
</style>
@endsection
    @component('components.breadcrumb')
        @slot('title') Detalle de Cita @endslot
        @slot('li_1') Panel @endslot
        @slot('li_2') Citas @endslot
    @endcomponent

    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ url()->previous() }}" class="btn btn-primary">
                <i class="mdi mdi-arrow-left me-1"></i>{{ __('Volver') }}
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">{{ __('Información de la Cita') }}</h4>
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <tbody>
                                <tr>
                                    <th style="width: 280px;">{{ __('ID de Cita') }}</th>
                                    <td>{{ $appointment->id }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Paciente') }}</th>
                                    <td>{{ optional($appointment->patient)->first_name }} {{ optional($appointment->patient)->last_name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Odontólogo') }}</th>
                                    <td>{{ optional(optional($appointment->doctor)->user)->first_name }} {{ optional(optional($appointment->doctor)->user)->last_name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Fecha') }}</th>
                                    <td>{{ $appointment->appointment_date }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Hora') }}</th>
                                    <td>
                                        @if (optional($appointment->timeSlot)->from)
                                            {{ \Carbon\Carbon::parse(optional($appointment->timeSlot)->from)->format('H:i') }} a {{ \Carbon\Carbon::parse(optional($appointment->timeSlot)->to)->format('H:i') }}
                                        @else
                                            {{ __('Sin horario') }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('Estado') }}</th>
                                    <td>
                                        @if ((int) $appointment->status === 1)
                                            <span class="badge badge-pill text-white" style="background-color:#198754;">{{ __('Completada') }}</span>
                                        @elseif ((int) $appointment->status === 2)
                                            <span class="badge badge-pill text-white" style="background-color:#dc3545;">{{ __('Cancelada') }}</span>
                                        @else
                                            <span class="badge badge-pill text-white" style="background-color:#0dcaf0;">{{ __('Pendiente') }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('Monto Final') }}</th>
                                    <td>
                                        @if (!is_null($appointment->final_consultation_price))
                                            ${{ number_format((float) $appointment->final_consultation_price, 2, '.', ',') }}
                                        @else
                                            {{ __('No definido') }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('Creada por') }}</th>
                                    <td>{{ optional($appointment->BookedBy)->first_name }} {{ optional($appointment->BookedBy)->last_name }}</td>
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
                    <h4 class="card-title mb-2">{{ __('Historia Dental y Evaluación') }}</h4>
                    <p class="text-muted">{{ __('Rojo: zona afectada. Azul: zona trabajada o restaurada.') }}</p>
                    @if ($canEditDentalEvaluation)
                        <form method="POST" action="{{ route('appointment.dental-evaluation.save', $appointment->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ __('Diagnóstico') }}</label>
                                    <textarea name="diagnosis" class="form-control" rows="4" maxlength="5000">{{ old('diagnosis', optional($dentalEvaluation)->diagnosis) }}</textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ __('Tratamiento realizado') }}</label>
                                    <textarea name="treatment" class="form-control" rows="4" maxlength="5000">{{ old('treatment', optional($dentalEvaluation)->treatment) }}</textarea>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">{{ __('Cantidad') }}</label>
                                    <input type="number" name="quantity" min="0" step="0.01" class="form-control" value="{{ old('quantity', optional($dentalEvaluation)->quantity) }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">{{ __('Valor') }}</label>
                                    <input type="number" name="value" min="0" step="0.01" class="form-control" value="{{ old('value', optional($dentalEvaluation)->value) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ __('Notas clínicas / Historia de la cita') }}</label>
                                    <textarea name="clinical_notes" class="form-control" rows="3" maxlength="10000">{{ old('clinical_notes', optional($dentalEvaluation)->clinical_notes) }}</textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ __('Fotos de placas') }}</label>
                                    <input type="file" name="photos[]" class="form-control" accept="image/jpeg,image/png,image/webp" multiple>
                                    <small class="text-muted">{{ __('Puedes adjuntar hasta 10 imágenes de máximo 5 MB cada una.') }}</small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label d-block">{{ __('Odontograma') }}</label>
                                <div class="odontogram-grid mb-2">
                                    @foreach ($upperTeeth as $tooth)
                                        <button type="button" class="tooth-mark {{ $toothMarks[$tooth] ?? '' }}" data-tooth="{{ $tooth }}">{{ $tooth }}</button>
                                    @endforeach
                                    @foreach ($lowerTeeth as $tooth)
                                        <button type="button" class="tooth-mark {{ $toothMarks[$tooth] ?? '' }}" data-tooth="{{ $tooth }}">{{ $tooth }}</button>
                                    @endforeach
                                </div>
                                <div class="d-flex gap-3 small text-muted">
                                    <span><i class="fas fa-square text-danger me-1"></i>{{ __('Afectado') }}</span>
                                    <span><i class="fas fa-square text-primary me-1"></i>{{ __('Trabajado') }}</span>
                                </div>
                            </div>
                            <input type="hidden" name="tooth_marks" id="tooth_marks" value="{{ json_encode($toothMarks) }}">
                            <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save me-1"></i>{{ __('Guardar Historia Dental') }}</button>
                            @if ($dentalEvaluation && $dentalEvaluation->images->isNotEmpty())
                                <div class="mt-4">
                                    <h6>{{ __('Placas adjuntas') }}</h6>
                                    <div class="row">
                                        @foreach ($dentalEvaluation->images as $image)
                                            <div class="col-sm-3 col-6 mb-3">
                                                <a href="{{ asset('storage/' . $image->path) }}" target="_blank" rel="noopener">
                                                    <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->original_name }}" class="img-fluid rounded border" style="height: 130px; width: 100%; object-fit: cover;">
                                                </a>
                                                <small class="d-block text-truncate" title="{{ $image->original_name }}">{{ $image->original_name }}</small>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </form>
                    @else
                        <div class="row">
                            <div class="col-md-6"><strong>{{ __('Diagnóstico') }}</strong><p>{{ optional($dentalEvaluation)->diagnosis ?: __('Sin registrar') }}</p></div>
                            <div class="col-md-6"><strong>{{ __('Tratamiento realizado') }}</strong><p>{{ optional($dentalEvaluation)->treatment ?: __('Sin registrar') }}</p></div>
                            <div class="col-md-3"><strong>{{ __('Cantidad') }}</strong><p>{{ optional($dentalEvaluation)->quantity ?: '0' }}</p></div>
                            <div class="col-md-3"><strong>{{ __('Valor') }}</strong><p>{{ optional($dentalEvaluation)->value !== null ? number_format($dentalEvaluation->value, 2) : '0.00' }}</p></div>
                            <div class="col-12"><strong>{{ __('Notas clínicas') }}</strong><p>{{ optional($dentalEvaluation)->clinical_notes ?: __('Sin registrar') }}</p></div>
                        </div>
                        <div class="odontogram-grid">
                            @foreach (array_merge($upperTeeth, $lowerTeeth) as $tooth)
                                <span class="tooth-mark {{ $toothMarks[$tooth] ?? '' }} text-center pt-3">{{ $tooth }}</span>
                            @endforeach
                        </div>
                        @if ($dentalEvaluation && $dentalEvaluation->images->isNotEmpty())
                            <div class="mt-4">
                                <h6>{{ __('Placas adjuntas') }}</h6>
                                <div class="row">
                                    @foreach ($dentalEvaluation->images as $image)
                                        <div class="col-sm-3 col-6 mb-3">
                                            <a href="{{ asset('storage/' . $image->path) }}" target="_blank" rel="noopener"><img src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->original_name }}" class="img-fluid rounded border" style="height: 130px; width: 100%; object-fit: cover;"></a>
                                            <small class="d-block text-truncate">{{ $image->original_name }}</small>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
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
@endsection

@extends('layouts.master-layouts')
@section('title') {{ __('Citas Completadas') }} @endsection
    @section('content')
        <!-- start page title -->
        @component('components.breadcrumb')
            @slot('title') Citas Completadas @endslot
            @slot('li_1') Panel @endslot
            @slot('li_2') Citas @endslot
        @endcomponent
        <!-- end page title -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('today-appointment') }}">
                                    <span class="d-block d-sm-none"><i class="fas fa-calendar-day"></i></span>
                                    <span class="d-none d-sm-block">{{ __('Lista de Citas de Hoy') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="{{ url('pending-appointment') }}">
                                    <span class="d-block d-sm-none"><i class="far fa-calendar"></i></span>
                                    <span class="d-none d-sm-block">{{ __('Lista de Citas Pendientes') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('upcoming-appointment') }}">
                                    <span class="d-block d-sm-none"><i class="fas fa-calendar-week"></i></span>
                                    <span class="d-none d-sm-block">{{ __('Lista de Próximas Citas') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ url('complete-appointment') }}">
                                    <span class="d-block d-sm-none"><i class="fas fa-check-square"></i></span>
                                    <span class="d-none d-sm-block">{{ __('Lista de Citas Completadas') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('cancel-appointment') }}">
                                    <span class="d-block d-sm-none"><i class="fas fa-window-close"></i></span>
                                    <span class="d-none d-sm-block">{{ __('Lista de Citas Canceladas') }}</span>
                                </a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="PendingAppointmentList" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-bordered dt-responsive nowrap "
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Nro.') }}</th>
                                                <th>{{ __('Nombre del Odontólogo') }}</th>
                                                <th>{{ __('Nombre del Paciente') }}</th>
                                                <th>{{ __('Teléfono del Paciente') }}</th>
                                                <th>{{ __('Correo del Paciente') }}</th>
                                                <th>{{ __('Fecha') }}</th>
                                                <th>{{ __('Hora') }}</th>
                                                <th>{{ __('Estado') }}</th>
                                                <th>{{ __('Total del Servicio') }}</th>
                                                <th>{{ __('Precio Final Consulta') }}</th>
                                                <th>{{ __('Acción') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (session()->has('page_limit'))
                                                @php
                                                    $per_page = session()->get('page_limit');
                                                @endphp
                                            @else
                                                @php
                                                    $per_page = Config::get('app.page_limit');
                                                @endphp
                                            @endif
                                            @php
                                                $currentpage = $Complete_appointment->currentPage();
                                            @endphp
                                            @foreach ($Complete_appointment as $item)
                                                <tr>
                                                    <td>{{ $loop->index + 1 + $per_page * ($currentpage - 1) }}</td>
                                                    <td> {{ trim((optional(optional($item->doctor)->user)->first_name ?? '') . ' ' . (optional(optional($item->doctor)->user)->last_name ?? '')) ?: 'Sin doctor asignado' }}
                                                    </td>
                                                    <td> {{ trim((optional($item->patient)->first_name ?? '') . ' ' . (optional($item->patient)->last_name ?? '')) ?: 'Sin paciente asignado' }}
                                                    </td>
                                                    <td> {{ optional($item->patient)->mobile ?? '-' }} </td>
                                                    <td>{{ optional($item->patient)->email ?? '-' }}</td>
                                                    <td>{{ $item->appointment_date }}</td>
                                                    <td>{{ $item->time_range_label }}</td>
                                                    <td>
                                                        @if ($item->status == 1)
                                                            <span class="badge badge-pill text-white" style="background-color:#198754;">Completado</span>
                                                        @elseif($item->status == 2)
                                                            <span class="badge badge-pill text-white" style="background-color:#dc3545;">Cancelado</span>
                                                        @else
                                                            <span class="badge badge-pill text-white" style="background-color:#0dcaf0;">Pendiente</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ number_format((float) ($invoiceTotals[$item->id] ?? 0), 2, ',', '.') }}</td>
                                                    <td>
                                                        <input type="number" step="0.01" min="0" class="form-control form-control-sm final-consultation-price"
                                                            data-id="{{ $item->id }}"
                                                            value="{{ old('final_consultation_price', $item->final_consultation_price ?? ($invoiceTotals[$item->id] ?? '')) }}"
                                                            placeholder="0.00">
                                                    </td>
                                                    <td>
                                                        <a href="{{ url('appointment-view/' . $item->id) }}" class="btn btn-primary btn-sm mb-1">Ver</a>
                                                        @if (($role == 'doctor' || $role == 'receptionist' || $role == 'admin') && (int) $item->status !== 1)
                                                            <button type="button" class="btn btn-success btn-sm complete mb-1" data-id="{{ $item->id }}">Completar</button>
                                                            <button type="button" class="btn btn-danger btn-sm cancel mb-1" data-id="{{ $item->id }}">Cancelar</button>
                                                        @endif
                                                        <button type="button" class="btn btn-sm btn-primary save-final-price" data-id="{{ $item->id }}">
                                                            Guardar
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <input type="hidden" id="csrf_token_value" value="{{ csrf_token() }}">
                                </div>
                                <div class="col-md-12 text-center mt-3">
                                    <div class="d-flex justify-content-start">
                                        Mostrando {{ $Complete_appointment->firstItem() }} a
                                        {{ $Complete_appointment->lastItem() }} de
                                        {{ $Complete_appointment->total() }}
                                        registros
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        {{ $Complete_appointment->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('script')
        <!-- Plugins js -->
        <script src="{{ URL::asset('build/libs/jszip/jszip.min.js') }}"></script>
        <script src="{{ URL::asset('build/libs/pdfmake/build/pdfmake.min.js') }}"></script>
        <!-- Init js-->
        <script src="{{ URL::asset('build/js/pages/notification.init.js') }}"></script>
        <script src="{{ URL::asset('build/js/pages/appointment.js') }}"></script>
        <script>
            $(document).on('click', '.save-final-price', function() {
                var appointmentId = $(this).data('id');
                var input = $('.final-consultation-price[data-id="' + appointmentId + '"]');
                var amount = input.val();
                var token = "{{ csrf_token() }}";

                if (amount === '' || Number(amount) < 0) {
                    toastr.error('Ingrese un precio final válido.');
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: 'appointment-final-price/' + appointmentId,
                    data: {
                        _token: token,
                        final_consultation_price: amount
                    },
                    success: function(response) {
                        toastr.success(response.message || 'Precio final guardado.');
                    },
                    error: function(xhr) {
                        var msg = 'No se pudo guardar el precio final.';
                        if (xhr.responseJSON && (xhr.responseJSON.message || xhr.responseJSON.Message)) {
                            msg = xhr.responseJSON.message || xhr.responseJSON.Message;
                        }
                        toastr.error(msg);
                    }
                });
            });
        </script>
    @endsection

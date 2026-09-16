@extends('layouts.master-layouts')
@section('title') {{ __('Citas Canceladas') }} @endsection
    @section('content')
        <!-- start page title -->
        @component('components.breadcrumb')
            @slot('title') Citas Canceladas @endslot
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
                                <a class="nav-link" href="{{ url('complete-appointment') }}">
                                    <span class="d-block d-sm-none"><i class="fas fa-check-square"></i></span>
                                    <span class="d-none d-sm-block">{{ __('Lista de Citas Completadas') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ url('cancel-appointment') }}">
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
                                                $currentpage = $Cancel_appointment->currentPage();
                                            @endphp
                                            @foreach ($Cancel_appointment as $item)
                                                <tr>
                                                    <td>{{ $loop->index + 1 + $per_page * ($currentpage - 1) }}</td>
                                                    <td>{{ trim((optional(optional($item->doctor)->user)->first_name ?? '') . ' ' . (optional(optional($item->doctor)->user)->last_name ?? '')) ?: 'Sin doctor asignado' }}</td>
                                                    <td>{{ trim((optional($item->patient)->first_name ?? '') . ' ' . (optional($item->patient)->last_name ?? '')) ?: 'Sin paciente asignado' }}
                                                    </td>
                                                    <td>{{ optional($item->patient)->mobile ?? '-' }}</td>
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
                                                    <td>
                                                        <a href="{{ url('appointment-view/' . $item->id) }}" class="btn btn-primary mb-2 mb-md-0">Ver</a>
                                                        @if (($role == 'doctor' || $role == 'receptionist' || $role == 'admin') && (int) $item->status !== 1)
                                                            <button type="button" class="btn btn-success complete mb-2 mb-md-0" data-id="{{ $item->id }}">Completar</button>
                                                            <button type="button" class="btn btn-danger cancel mb-2 mb-md-0" data-id="{{ $item->id }}">Cancelar</button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <input type="hidden" id="csrf_token_value" value="{{ csrf_token() }}">
                                </div>
                                <div class="col-md-12 text-center mt-3">
                                    <div class="d-flex justify-content-start">
                                        Mostrando {{ $Cancel_appointment->firstItem() }} a
                                        {{ $Cancel_appointment->lastItem() }} de {{ $Cancel_appointment->total() }}
                                        registros
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        {{ $Cancel_appointment->links() }}
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
    @endsection

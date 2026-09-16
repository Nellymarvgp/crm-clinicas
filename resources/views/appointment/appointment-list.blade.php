@extends('layouts.master-layouts')
@section('title') {{ __('Lista de Citas') }} @endsection
@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('build/libs/datatables/datatables.min.css') }}">
@endsection
    @section('content')
        <!-- start page title -->
        @component('components.breadcrumb')
            @slot('title') Lista de Citas @endslot
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
                                <a class="nav-link active" data-bs-toggle="tab" href="#PendingAppointmentList" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">{{ __('Lista de Citas Pendientes') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#UpcomingAppointmentList" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">{{ __('Lista de Próximas Citas') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#ComplateAppointmentList" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">{{ __('Lista de Citas Completadas') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#CancelAppointmentList" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">{{ __('Lista de Citas Canceladas') }}</span>
                                </a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="PendingAppointmentList" role="tabpanel">
                                <table class="table table-bordered dt-responsive nowrap datatable"
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
                                            $currentpage = $pending_appointment->currentPage();
                                        @endphp
                                        @foreach ($pending_appointment as $item)
                                            <tr>
                                                <td> {{ $loop->index + 1 + $per_page * ($currentpage - 1) }} </td>
                                                <td> {{ @$item->doctor->user->first_name . ' ' . @$item->doctor->user->last_name }}
                                                </td>
                                                <td> {{ $item->patient->first_name . ' ' . $item->patient->last_name }}
                                                </td>
                                                <td> {{ $item->patient->mobile }} </td>
                                                <td> {{ $item->patient->email }} </td>
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
                                                    <a href="{{ url('appointment-view/' . $item->id) }}" class="btn btn-primary btn-sm mb-1">Ver</a>
                                                    @if (($role == 'doctor' || $role == 'receptionist') && (int) $item->status !== 1)
                                                        <button type="button" class="btn btn-success complete"
                                                            data-id="{{ $item->id }}">Completar</button>
                                                    @endif
                                                    @if ((int) $item->status !== 1)
                                                        <button type="button" class="btn btn-danger cancel"
                                                            data-id="{{ $item->id }}">Cancelar</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="UpcomingAppointmentList" role="tabpanel">
                                <table class="table table-bordered dt-responsive nowrap datatable"
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
                                            $currentpage = $Upcoming_appointment->currentPage();
                                        @endphp
                                        @foreach ($Upcoming_appointment as $item)
                                            <tr>
                                                <td> {{ $loop->index + 1 + $per_page * ($currentpage - 1) }} </td>
                                                <td> {{ @$item->doctor->user->first_name . ' ' . @$item->doctor->user->last_name }}
                                                </td>
                                                <td> {{ $item->patient->first_name . ' ' . $item->patient->last_name }}
                                                </td>
                                                <td> {{ $item->patient->mobile }} </td>
                                                <td>{{ $item->patient->email }}</td>
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
                                                    <a href="{{ url('appointment-view/' . $item->id) }}" class="btn btn-primary btn-sm mb-1">Ver</a>
                                                    @if (($role == 'doctor' || $role == 'receptionist' || $role == 'admin') && (int) $item->status !== 1)
                                                        <button type="button" class="btn btn-success btn-sm complete mb-1" data-id="{{ $item->id }}">Completar</button>
                                                        <button type="button" class="btn btn-danger btn-sm cancel mb-1" data-id="{{ $item->id }}">Cancelar</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="ComplateAppointmentList" role="tabpanel">
                                <table class="table table-bordered dt-responsive nowrap datatable"
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
                                            $currentpage = $Complete_appointment->currentPage();
                                        @endphp
                                        @foreach ($Complete_appointment as $item)
                                            <tr>
                                                <td> {{ $loop->index + 1 + $per_page * ($currentpage - 1) }} </td>
                                                <td> {{ @$item->doctor->user->first_name . ' ' . @$item->doctor->user->last_name }}
                                                </td>
                                                <td> {{ $item->patient->first_name . ' ' . $item->patient->last_name }}
                                                </td>
                                                <td> {{ $item->patient->mobile }} </td>
                                                <td>{{ $item->patient->email }}</td>
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
                                                    <a href="{{ url('appointment-view/' . $item->id) }}" class="btn btn-primary btn-sm mb-1">Ver</a>
                                                    @if (($role == 'doctor' || $role == 'receptionist' || $role == 'admin') && (int) $item->status !== 1)
                                                        <button type="button" class="btn btn-success btn-sm complete mb-1" data-id="{{ $item->id }}">Completar</button>
                                                        <button type="button" class="btn btn-danger btn-sm cancel mb-1" data-id="{{ $item->id }}">Cancelar</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="CancelAppointmentList" role="tabpanel">
                                <table class="table table-bordered dt-responsive nowrap datatable"
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
                                                <td> {{ $loop->index + 1 + $per_page * ($currentpage - 1) }} </td>
                                                <td> {{ @$item->doctor->user->first_name . ' ' . @$item->doctor->user->last_name }}
                                                </td>
                                                <td> {{ $item->patient->first_name . ' ' . $item->patient->last_name }}
                                                </td>
                                                <td> {{ $item->patient->mobile }} </td>
                                                <td>{{ $item->patient->email }}</td>
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
                                                    <a href="{{ url('appointment-view/' . $item->id) }}" class="btn btn-primary btn-sm mb-1">Ver</a>
                                                    @if (($role == 'doctor' || $role == 'receptionist' || $role == 'admin') && (int) $item->status !== 1)
                                                        <button type="button" class="btn btn-success btn-sm complete mb-1" data-id="{{ $item->id }}">Completar</button>
                                                        <button type="button" class="btn btn-danger btn-sm cancel mb-1" data-id="{{ $item->id }}">Cancelar</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <input type="hidden" id="csrf_token_value" value="{{ csrf_token() }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('script')
        <!-- Plugins js -->
        <script src="{{ URL::asset('build/libs/datatables/datatables.min.js') }}"></script>
        <script src="{{ URL::asset('build/libs/jszip/jszip.min.js') }}"></script>
        <script src="{{ URL::asset('build/libs/pdfmake/build/pdfmake.min.js') }}"></script>
        <!-- Init js-->
        <script src="{{ URL::asset('build/js/pages/datatables.init.js') }}"></script>
        <script src="{{ URL::asset('build/js/pages/notification.init.js') }}"></script>
        <script src="{{ URL::asset('build/js/pages/appointment.js') }}"></script>
    @endsection
    @section('script-bottom')
        <script>
            // active tab
            if (window.location.href) {
                var url = window.location.href;
                var activeTab = url.substring(url.indexOf("#") + 1);
                var URL = document.location.origin;
                if (url.substring(url.indexOf("#") + 1) == URL + '/appointment-list') {
                    $("#PendingAppointmentList").addClass("active in");
                } else {
                    $(".tab-pane").removeClass("active in");
                    $("#" + activeTab).addClass("active in");
                    $('a[href="#' + activeTab + '"]').tab('show')
                }
            }
        </script>
    @endsection

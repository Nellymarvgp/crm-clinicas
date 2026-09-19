@extends('layouts.master-layouts')
@section('title') {{ __('Agendar Cita') }} @endsection
@section('css')
    <!-- Calender -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('build/libs/fullcalendar/fullcalendar.min.css') }}">
@endsection
    @section('content')
        <!-- start page title -->
        @component('components.breadcrumb')
            @slot('title') Agendar Cita @endslot
            @slot('li_1') Panel @endslot
            @slot('li_2') Citas @endslot
        @endcomponent
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <a href="{{ url('/pending-appointment') }}"
                    class="btn btn-outline-primary waves-effect waves-light mb-4 me-2">
                    <i class="bx bx-list-ul font-size-16 align-middle me-2"></i> {{ __('Ver Citas') }}
                </a>
                <a href="{{ url('/appointment-create') }}"
                    class="btn btn-primary text-white waves-effect waves-light mb-4">
                    <i class="bx bx-plus font-size-16 align-middle me-2"></i> {{ __('Nueva Cita') }}
                </a>
            </div> <!-- end col -->
        </div> <!-- end row -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div id='calendar'></div>
                    </div>
                </div>
            </div> <!-- end col -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">{{ __('Lista de Citas') }} | <label
                            id="selected_date">{{ \Carbon\Carbon::now()->locale('es')->translatedFormat('d/m/Y') }}</label>
                        </h4>
                        <div id="appointment_list">
                            <table class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="thead-light">
                                    <tr>
                                        <th>{{ __('Nro.') }}</th>
                                        @if ($role == 'patient')
                                            <th>{{ __('Nombre del Odontólogo') }}</th>
                                            <th>{{ __('Número del Odontólogo') }}</th>
                                        @elseif($role == 'doctor')
                                            <th>{{ __('Nombre del Paciente') }}</th>
                                            <th>{{ __('Número del Paciente') }}</th>
                                        @else
                                            <th>{{ __('Nombre del Paciente') }}</th>
                                            <th>{{ __('Nombre del Odontólogo') }}</th>
                                            <th>{{ __('Número del Paciente') }}</th>

                                        @endif
                                        <th>{{ __('Hora') }}</th>
                                        <th>{{ __('Estado') }}</th>
                                        @if ($role == 'admin' || $role == 'doctor' || $role == 'receptionist')
                                            <th>{{ __('Acción') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @if ($role == 'receptionist')
                                        @foreach ($appointments as $appointment)
                                            <tr>
                                                <td> {{ $i }} </td>
                                                <td>{{ $appointment->patient->first_name . ' ' . $appointment->patient->last_name }}
                                                </td>
                                                <td>{{ @$appointment->doctor->user->first_name . ' ' . @$appointment->doctor->user->last_name }}
                                                </td>
                                                <td>{{ $appointment->patient->mobile }}</td>
                                                <td>
                                                    {{ optional($appointment->timeSlot)->from ? \Carbon\Carbon::parse(optional($appointment->timeSlot)->from)->format('H:i') . ' a ' . \Carbon\Carbon::parse(optional($appointment->timeSlot)->to)->format('H:i') : 'Sin horario' }}
                                                </td>
                                                <td>
                                                    @if ($appointment->status == 1)
                                                        <span class="badge badge-pill text-white" style="background-color:#198754;">Completado</span>
                                                    @elseif($appointment->status == 2)
                                                        <span class="badge badge-pill text-white" style="background-color:#dc3545;">Cancelado</span>
                                                    @else
                                                        <span class="badge badge-pill text-white" style="background-color:#0dcaf0;">Pendiente</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ url('appointment-view/' . $appointment->id) }}" class="btn btn-primary mb-1">{{ __('Ver') }}</a>
                                                    @if ((int) $appointment->status !== 1)
                                                        <button type="button" class="btn btn-success complete mb-1" data-id="{{ $appointment->id }}">{{ __('Completar') }}</button>
                                                        <button type="button" class="btn btn-danger cancel mb-1" data-id="{{ $appointment->id }}">{{ __('Cancelar') }}</button>
                                                    @endif
                                                </td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    @elseif ($role == 'admin')
                                        @foreach ($appointments as $appointment)
                                            <tr>
                                                <td> {{ $i }} </td>
                                                <td>{{ $appointment->patient->first_name . ' ' . $appointment->patient->last_name }}
                                                </td>
                                                <td>{{ @$appointment->doctor->user->first_name . ' ' . @$appointment->doctor->user->last_name }}
                                                </td>
                                                <td>{{ $appointment->patient->mobile }}</td>
                                                <td>
                                                    {{ optional($appointment->timeSlot)->from ? \Carbon\Carbon::parse(optional($appointment->timeSlot)->from)->format('H:i') . ' a ' . \Carbon\Carbon::parse(optional($appointment->timeSlot)->to)->format('H:i') : 'Sin horario' }}
                                                </td>
                                                <td>
                                                    @if ($appointment->status == 1)
                                                        <span class="badge badge-pill text-white" style="background-color:#198754;">Completado</span>
                                                    @elseif($appointment->status == 2)
                                                        <span class="badge badge-pill text-white" style="background-color:#dc3545;">Cancelado</span>
                                                    @else
                                                        <span class="badge badge-pill text-white" style="background-color:#0dcaf0;">Pendiente</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ url('appointment-view/' . $appointment->id) }}" class="btn btn-primary mb-1">{{ __('Ver') }}</a>
                                                    @if ((int) $appointment->status !== 1)
                                                        <button type="button" class="btn btn-success complete mb-1" data-id="{{ $appointment->id }}">{{ __('Completar') }}</button>
                                                        <button type="button" class="btn btn-danger cancel mb-1" data-id="{{ $appointment->id }}">{{ __('Cancelar') }}</button>
                                                    @endif
                                                </td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    @elseif ($role == 'doctor')
                                        @foreach ($appointments as $appointment)
                                            <tr>
                                                <td> {{ $i }} </td>
                                                <td>{{ $appointment->patient->first_name . ' ' . $appointment->patient->last_name }}
                                                </td>
                                                <td>{{ $appointment->patient->mobile }}</td>
                                                <td>
                                                    {{ optional($appointment->timeSlot)->from ? \Carbon\Carbon::parse(optional($appointment->timeSlot)->from)->format('H:i') . ' a ' . \Carbon\Carbon::parse(optional($appointment->timeSlot)->to)->format('H:i') : 'Sin horario' }}
                                                </td>
                                                <td>
                                                    @if ($appointment->status == 1)
                                                        <span class="badge badge-pill text-white" style="background-color:#198754;">Completado</span>
                                                    @elseif($appointment->status == 2)
                                                        <span class="badge badge-pill text-white" style="background-color:#dc3545;">Cancelado</span>
                                                    @else
                                                        <span class="badge badge-pill text-white" style="background-color:#0dcaf0;">Pendiente</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ url('appointment-view/' . $appointment->id) }}" class="btn btn-primary mb-1">{{ __('Ver') }}</a>
                                                    @if ((int) $appointment->status !== 1)
                                                        <button type="button" class="btn btn-success complete mb-1" data-id="{{ $appointment->id }}">{{ __('Completar') }}</button>
                                                        <button type="button" class="btn btn-danger cancel mb-1" data-id="{{ $appointment->id }}">{{ __('Cancelar') }}</button>
                                                    @endif
                                                </td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    @elseif ($role == 'patient')
                                        @foreach ($appointments as $appointment)
                                            <tr>
                                                <td> {{ $i }} </td>
                                                <td>{{ @$appointment->doctor->user->first_name . ' ' . @$appointment->doctor->user->last_name }}
                                                </td>
                                                <td>{{ @$appointment->doctor->user->mobile }}</td>
                                                <td>
                                                    {{ optional($appointment->timeSlot)->from ? \Carbon\Carbon::parse(optional($appointment->timeSlot)->from)->format('H:i') . ' a ' . \Carbon\Carbon::parse(optional($appointment->timeSlot)->to)->format('H:i') : 'Sin horario' }}
                                                </td>
                                                <td>
                                                    @if ($appointment->status == 1)
                                                        <span class="badge badge-pill text-white" style="background-color:#198754;">Completado</span>
                                                    @elseif($appointment->status == 2)
                                                        <span class="badge badge-pill text-white" style="background-color:#dc3545;">Cancelado</span>
                                                    @else
                                                        <span class="badge badge-pill text-white" style="background-color:#0dcaf0;">Pendiente</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <input type="hidden" id="csrf_token_value" value="{{ csrf_token() }}">
                        </div>
                        <div id="new_list" style="display : none"></div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    @endsection
    @section('script')
        <!-- Calender Js-->
        <script src="{{ URL::asset('build/libs/select2/js/select2.min.js') }}"></script>
        <script src="{{ URL::asset('build/libs/jquery-ui/jquery-ui.min.js') }}"></script>
        <script src="{{ URL::asset('build/libs/moment/moment.js') }}"></script>
        <script src="{{ URL::asset('build/libs/fullcalendar/index.global.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/locales/es.global.min.js"></script>
        <!-- Get App url in Javascript file -->
        <script type="text/javascript">
            var aplist_url = "{{ url('appointmentList') }}";
        </script>
        <!-- Init js-->
        <script src="{{ URL::asset('build/js/pages/calendar-init.js') }}"></script>
        <script src="{{ URL::asset('build/js/pages/form-advanced.init.js') }}"></script>
        <script src="{{ URL::asset('build/js/pages/appointment.js') }}"></script>
    @endsection

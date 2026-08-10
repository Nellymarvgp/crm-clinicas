@extends('layouts.master-layouts')
@section('title') {{ __('Detalle de Cita') }} @endsection
@section('content')
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
@endsection

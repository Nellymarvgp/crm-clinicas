@extends('layouts.master-layouts')
@section('title') {{ __('Perfil del Paciente') }} @endsection
    @section('content')
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">
                        {{ __('Perfil del Paciente') }}
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">{{ __('Panel') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('patient') }}">{{ __('Pacientes') }}</a></li>
                            <li class="breadcrumb-item active">
                                {{ __('Perfil del Paciente') }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-xl-4">
                <div class="card overflow-hidden">
                    <div class="bg-primary-subtle">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-3">
                                    <h5 class="text-primary">{{ __('Información del Paciente') }}</h5>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="{{ URL::asset('build/images/profile-img.png') }}" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="avatar-md profile-user-wid mb-4">
                                    <img src="@if ($patient->profile_photo != null){{ URL::asset('storage/images/users/' . $patient->profile_photo) }}@else{{ URL::asset('build/images/users/noImage.png') }}@endif" alt="{{ $patient->first_name }}"
                                        class="img-thumbnail rounded-circle">
                                </div>
                                <h5 class="font-size-15 text-truncate"> {{ $patient->first_name }}
                                    {{ $patient->last_name }}</h5>
                            </div>
                            <div class="col-sm-8">
                                <div class="pt-4">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5 class="font-size-12">{{ __('Último acceso:') }}</h5>
                                            <p class="text-muted mb-0"> {{ $patient->last_login }} </p>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <a href="{{ url('patient/' . $patient->id . '/edit') }}"
                                            class="btn btn-primary waves-effect waves-light btn-sm">{{ __('Editar Perfil ') }}<i
                                                class="mdi mdi-arrow-right ms-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">{{ __('Información Personal') }}</h4>
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <tbody>
                                    <tr>
                                        <th scope="row">{{ __('Nombre Completo:') }}</th>
                                        <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('Nro. de Contacto:') }}</th>
                                        <td> {{ $patient->mobile }} </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('Email:') }}</th>
                                        <td> {{ $patient->email }} </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('Edad:') }}</th>
                                        <td> {{ $patient_info->age }} </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('Género:') }}</th>
                                        <td>
                                            {{ strtolower((string) $patient_info->gender) === 'female' ? 'Femenino' : (strtolower((string) $patient_info->gender) === 'male' ? 'Masculino' : $patient_info->gender) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('Dirección:') }}</th>
                                        <td> {{ $patient_info->address }} </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- end card -->
            </div>
            <div class="col-xl-8">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">{{ __('Citas') }}</p>
                                        <h4 class="mb-0">{{ number_format($data['total_appointment']) }}</h4>
                                    </div>
                                    <div class="mini-stat-icon avatar-sm align-self-center rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-check-circle font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">{{ __('Facturas Pendientes') }}</p>
                                        <h4 class="mb-0">{{ number_format($data['pending_bill']) }}</h4>
                                    </div>
                                    <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-hourglass font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">{{ __('Total Facturado') }}</p>
                                        <h4 class="mb-0">${{ number_format($data['revenue'], 2) }}</h4>
                                    </div>
                                    <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-package font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#Medical_info" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">{{ __('Información Médica') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#DentalHistory" role="tab">
                                    <span class="d-none d-sm-block">{{ __('Historia Dental') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#AppointmentList" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">{{ __('Lista de Citas') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#PrescriptionList" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">{{ __('Lista de Recetas') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#Invoices" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">{{ __('Facturas') }}</span>
                                </a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="Medical_info" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <tbody>
                                            <tr>
                                                <th scope="row">{{ __('Estatura') }}</th>
                                                <td> {{ $medical_Info->height ?? __('No registrado') }} </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Peso') }}</th>
                                                <td> {{ $medical_Info->weight ?? __('No registrado') }} </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Grupo Sanguíneo') }}</th>
                                                <td> {{ $medical_Info->b_group ?? __('No registrado') }} </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Presión Arterial') }}</th>
                                                <td> {{ $medical_Info->b_pressure ?? __('No registrado') }} </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Pulso') }}</th>
                                                <td> {{ $medical_Info->pulse ?? __('No registrado') }} </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Respiración') }}</th>
                                                <td> {{ $medical_Info->respiration ?? __('No registrado') }} </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Alergia') }}</th>
                                                <td> {{ $medical_Info->allergy ?? __('No registrado') }} </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Dieta') }}</th>
                                                <td>
                                                    @if (($medical_Info->diet ?? '') === 'Vegetarian') Vegetariana
                                                    @elseif (($medical_Info->diet ?? '') === 'Non-vegetarian') No vegetariana
                                                    @elseif (($medical_Info->diet ?? '') === 'Vegan') Vegana
                                                    @else {{ $medical_Info->diet ?? '' }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Diabetes') }}</th>
                                                <td>{{ ($medical_Info->diabetes_status ?? '') === 'si' ? 'Si' : (($medical_Info->diabetes_status ?? '') === 'no' ? 'No' : '') }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Diabetes controlado') }}</th>
                                                <td>{{ ($medical_Info->diabetes_controlled ?? '') === 'si' ? 'Si' : (($medical_Info->diabetes_controlled ?? '') === 'no' ? 'No' : '') }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Hipertensión') }}</th>
                                                <td>{{ ($medical_Info->hypertension_status ?? '') === 'si' ? 'Si' : (($medical_Info->hypertension_status ?? '') === 'no' ? 'No' : '') }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Hipertensión controlada') }}</th>
                                                <td>{{ ($medical_Info->hypertension_controlled ?? '') === 'si' ? 'Si' : (($medical_Info->hypertension_controlled ?? '') === 'no' ? 'No' : '') }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Actualmente embarazada') }}</th>
                                                <td>{{ ($medical_Info->currently_pregnant ?? '') === 'si' ? 'Si' : (($medical_Info->currently_pregnant ?? '') === 'no' ? 'No' : '') }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Antecedentes de infarto') }}</th>
                                                <td>{{ ($medical_Info->heart_attack_history ?? '') === 'si' ? 'Si' : (($medical_Info->heart_attack_history ?? '') === 'no' ? 'No' : '') }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Último infarto') }}</th>
                                                <td>{{ $medical_Info->last_heart_attack ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Consume medicamentos') }}</th>
                                                <td>{{ ($medical_Info->takes_medications ?? '') === 'si' ? 'Si' : (($medical_Info->takes_medications ?? '') === 'no' ? 'No' : '') }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Medicamentos') }}</th>
                                                <td>{{ $medical_Info->medications_list ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Aspirina en las últimas 72 horas') }}</th>
                                                <td>{{ ($medical_Info->aspirin_last_72h ?? '') === 'si' ? 'Si' : (($medical_Info->aspirin_last_72h ?? '') === 'no' ? 'No' : '') }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Padece alguna enfermedad') }}</th>
                                                <td>{{ ($medical_Info->has_disease ?? '') === 'si' ? 'Si' : (($medical_Info->has_disease ?? '') === 'no' ? 'No' : '') }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Enfermedad') }}</th>
                                                <td>{{ $medical_Info->disease_details ?? '' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="DentalHistory" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead><tr><th>{{ __('Fecha') }}</th><th>{{ __('Diagnóstico') }}</th><th>{{ __('Tratamiento') }}</th><th>{{ __('Cantidad') }}</th><th>{{ __('Valor') }}</th><th>{{ __('Detalle') }}</th></tr></thead>
                                        <tbody>
                                            @forelse ($appointments as $item)
                                                @if ($item->dentalEvaluation)
                                                    <tr>
                                                        <td>{{ $item->appointment_date }}</td>
                                                        <td>{{ $item->dentalEvaluation->diagnosis ?: __('Sin registrar') }}</td>
                                                        <td>{{ $item->dentalEvaluation->treatment ?: __('Sin registrar') }}</td>
                                                        <td>{{ $item->dentalEvaluation->quantity ?: '0' }}</td>
                                                        <td>{{ $item->dentalEvaluation->value !== null ? number_format($item->dentalEvaluation->value, 2) : '0.00' }}</td>
                                                        <td><a href="{{ url('appointment-view/' . $item->id) }}#dental-history" class="btn btn-primary btn-sm">{{ __('Ver') }}</a></td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr><td colspan="6">{{ __('Sin evaluaciones registradas') }}</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="AppointmentList" role="tabpanel">
                                <table class="table table-bordered dt-responsive nowrap "
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Nro.') }}</th>
                                            <th>Doctor</th>
                                            <th>{{ __('Fecha') }}</th>
                                            <th>{{ __('Hora') }}</th>
                                        </tr>
                                    </thead>
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
                                        $currentpage = $invoices->currentPage();
                                    @endphp
                                    @foreach ($appointments as $item)
                                        <tr>
                                            <td>{{ $loop->index + 1 + $per_page * ($currentpage - 1) }}</td>
                                            <td>{{ @$item->doctor->user->first_name }} {{ @$item->doctor->user->last_name }}</td>
                                            <td>{{ $item->appointment_date }}</td>
                                            <td>{{ optional($item->timeSlot)->from ? optional($item->timeSlot)->from . ' to ' . optional($item->timeSlot)->to : 'Sin horario' }}</td>
                                            <td>
                                                @if ($item->dentalEvaluation)
                                                    <a href="{{ url('appointment-view/' . $item->id) }}#dental-history" class="btn btn-outline-primary btn-sm">Ver Historia</a>
                                                @else
                                                    Sin evaluación
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="col-md-12 text-center mt-3">
                                    <div class="d-flex justify-content-start">
                                        Mostrando {{ $appointments->firstItem() }} a {{ $appointments->lastItem() }} de
                                        {{ $appointments->total() }} registros
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        {{ $appointments->links() }}
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="PrescriptionList" role="tabpanel">
                                <table class="table table-bordered dt-responsive nowrap "
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Nro.') }}</th>
                                            <th>Doctor</th>
                                            <th>{{ __('Fecha') }}</th>
                                            <th>{{ __('Opción') }}</th>
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
                                            $currentpage = $prescriptions->currentPage();
                                        @endphp
                                        @foreach ($prescriptions as $item)
                                            <tr>
                                                <td>{{ $loop->index + 1 + $per_page * ($currentpage - 1) }}</td>
                                                <td>{{ @$item->doctor->user->first_name }} {{ @$item->doctor->user->last_name }}
                                                </td>
                                                <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                                <td>
                                                    <a href="{{ url('prescription/' . $item->id) }}">
                                                        <button type="button"
                                                            class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                                            {{ __('Ver') }}
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="col-md-12 text-center mt-3">
                                    <div class="d-flex justify-content-start">
                                        Mostrando {{ $prescriptions->firstItem() }} a {{ $prescriptions->lastItem() }}
                                        de {{ $prescriptions->total() }} registros
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        {{ $prescriptions->links() }}
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="Invoices" role="tabpanel">
                                <table class="table table-bordered dt-responsive nowrap "
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Nro.') }}</th>
                                            <th>{{ __('Fecha') }}</th>
                                            <th>{{ __('Estado') }}</th>
                                            <th>{{ __('Opción') }}</th>
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
                                            $currentpage = $invoices->currentPage();
                                        @endphp
                                        @foreach ($invoices as $item)
                                            <tr>
                                                <td>{{ $loop->index + 1 + $per_page * ($currentpage - 1) }}</td>
                                                <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                                <td>{{ $item->payment_status }}</td>
                                                <td>
                                                    <a href="{{ url('invoice/' . $item->id) }}">
                                                        <button type="button"
                                                            class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                                            {{ __('Ver') }}
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="col-md-12 text-center mt-3">
                                    <div class="d-flex justify-content-start">
                                        Mostrando {{ $invoices->firstItem() }} a {{ $invoices->lastItem() }} de
                                        {{ $invoices->total() }} registros
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        {{ $invoices->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    @endsection
    @section('script')
        <!-- flot plugins -->
        <script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>
        <!-- Plugins js -->
        <script src="{{ URL::asset('build/libs/jszip/jszip.min.js') }}"></script>
        <script src="{{ URL::asset('build/libs/pdfmake/build/pdfmake.min.js') }}"></script>
        <!-- Init js-->
        <script src="{{ URL::asset('build/js/pages/profile.init.js') }}"></script>
    @endsection

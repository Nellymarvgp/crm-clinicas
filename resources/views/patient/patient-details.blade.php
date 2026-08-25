@extends('layouts.master-layouts')
@section('title')
    @if ($patient )
        {{ __('Actualizar Datos del Paciente') }}
    @else
        {{ __('Agregar Nuevo Paciente') }}
    @endif
@endsection
    @section('content')
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">
                        @if ($patient && $patient_info && $medical_info)
                            {{ __('Update Patient Details') }}
                        @else
                            {{ __('Add New Patient') }}
                        @endif
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">{{ __('Panel') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('patient') }}">{{ __('Pacientes') }}</a></li>
                            <li class="breadcrumb-item active">
                                @if ($patient)
                                    {{ __('Actualizar Datos del Paciente') }}
                                @else
                                    {{ __('Agregar Nuevo Paciente') }}
                                @endif
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                @if ($patient && $patient_info && $medical_info)
                    @if ($role == 'patient')
                        <a href="{{ url('/dashboard') }}">
                            <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                                <i
                                    class="bx bx-arrow-back font-size-16 align-middle me-2"></i>{{ __('Volver al Panel') }}
                            </button>
                        </a>
                    @else
                        <a href="{{ url('patient/' . $patient->id) }}">
                            <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                                <i
                                    class="bx bx-arrow-back font-size-16 align-middle me-2"></i>{{ __('Volver al Perfil') }}
                            </button>
                        </a>
                    @endif
                @else
                    <a href="{{ url('patient') }}">
                        <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                            <i
                                class="bx bx-arrow-back font-size-16 align-middle me-2"></i>{{ __('Volver a la Lista de Pacientes') }}
                        </button>
                    </a>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <blockquote class="blockquote">{{ __('Información Básica') }}</blockquote>
                        <form action="@if ($patient ) {{ url('patient/' . $patient->id) }} @else {{ route('patient.store') }} @endif" method="post" enctype="multipart/form-data">
                            @csrf
                            @if ($patient )
                                <input type="hidden" name="_method" value="PATCH" />
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Nombres ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('first_name') is-invalid @enderror"
                                                name="first_name" id="FirstName" tabindex="1"
                                                value="@if ($patient){{ old('first_name', $patient->first_name) }}@elseif(old('first_name')){{ old('first_name') }}@endif"
                                                placeholder="{{ __('Ingrese los nombres') }}">
                                            @error('first_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-md-12">
                                            <label for="formmessage">{{ __('Género ') }}<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control @error('gender') is-invalid @enderror" tabindex="3"
                                                name="gender">
                                                <option selected disabled>{{ __('-- Seleccione Género --') }}</option>
                                                <option value="Male" @if (($patient_info && $patient_info->gender == 'Male') || old('gender') == 'Male') selected @endif>{{ __('Masculino') }}</option>
                                                <option value="Female" @if (($patient_info && $patient_info->gender == 'Female') || old('gender') == 'Female') selected @endif>{{ __('Femenino') }}
                                                </option>
                                                <option value="Other" @if (($patient_info && $patient_info->gender == 'Other') || old('gender') == 'Other') selected @endif>{{ __('Otro') }}</option>
                                            </select>
                                            @error('gender')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Correo Electrónico ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                tabindex="5" name="email" id="patientEmail" value="@if ($patient){{ old('email', $patient->email) }}@elseif(old('email')){{ old('email') }}@endif"
                                                placeholder="{{ __('Ingrese el correo electrónico') }}">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Dirección Actual ') }}<span
                                                    class="text-danger">*</span></label>
                                            <textarea id="formmessage" name="address" tabindex="7"
                                                class="form-control @error('address') is-invalid @enderror" rows="3"
                                                placeholder="{{ __('Ingrese la dirección actual') }}">@if ($patient && $patient_info ){{ $patient_info->address }}@elseif(old('address')){{ old('address') }}@endif</textarea>
                                            @error('address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Apellidos ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                                tabindex="2" name="last_name" id="LastName" value="@if ($patient){{ old('last_name', $patient->last_name) }}@elseif(old('last_name')){{ old('last_name') }}@endif"
                                                placeholder="{{ __('Ingrese los apellidos') }}">
                                            @error('last_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Edad ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('age') is-invalid @enderror"
                                                tabindex="4" name="age" id="patientAge" value="@if ($patient && $patient_info ){{ old('age', $patient_info->age) }}@elseif(old('age')){{ old('age') }}@endif"
                                                placeholder="{{ __('Ingrese la edad') }}">
                                            @error('age')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Número de Contacto ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="tel" class="form-control @error('mobile') is-invalid @enderror"
                                                tabindex="6" name="mobile" id="patientMobile"
                                                value="@if ($patient ){{ old('mobile', $patient->mobile) }}@elseif(old('mobile')){{ old('mobile') }}@endif"
                                                placeholder="{{ __('Ingrese el número de contacto') }}">
                                            @error('mobile')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Foto de Perfil ') }}</label>
                                            <img class="@error('profile_photo') is-invalid @enderror "
                                                src="@if ($patient && $patient->profile_photo != null){{ URL::asset('storage/images/users/' . $patient->profile_photo) }}@else{{ URL::asset('build/images/users/noImage.png') }}@endif" onclick="triggerClick()"
                                                data-bs-toggle="tooltip" data-placement="top"
                                                title="Haga clic para subir la foto de perfil" id="profile_display" />
                                            <input type="file"
                                                class="form-control @error('profile_photo') is-invalid @enderror"
                                                tabindex="8" name="profile_photo" id="profile_photo" style="display:none;"
                                                onchange="displayProfile(this)">
                                            @error('profile_photo')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <blockquote>{{ __('Información Médica') }}</blockquote>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Estatura ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('height') is-invalid @enderror"
                                                name="height" tabindex="9" value="@if ($patient && $patient_info && $medical_info){{ old('height', $medical_info->height) }}@elseif(old('height')){{ old('height') }}@endif"
                                                id="patientHeight" placeholder="{{ __('Ingrese la estatura en centímetros') }}">
                                            @error('height')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-md-12">
                                            <label for="formmessage">{{ __('Grupo Sanguíneo ') }}<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control @error('b_group') is-invalid @enderror"
                                                tabindex="11" name="b_group">
                                                <option selected disabled>{{ __('-- Seleccione Grupo Sanguíneo --') }}</option>
                                                <option value="A+" @if (($medical_info && $medical_info->b_group == 'A+') || old('b_group') == 'A+') selected @endif>{{ __('A+') }}</option>
                                                <option value="A-" @if (($medical_info && $medical_info->b_group == 'A-') || old('b_group') == 'A-') selected @endif>{{ __('A-') }}</option>
                                                <option value="B+" @if (($medical_info && $medical_info->b_group == 'B+') || old('b_group') == 'B+') selected @endif>{{ __('B+') }}</option>
                                                <option value="B-" @if (($medical_info && $medical_info->b_group == 'B-') || old('b_group') == 'B-') selected @endif>{{ __('B-') }}</option>
                                                <option value="O+" @if (($medical_info && $medical_info->b_group == 'O+') || old('b_group') == 'O+') selected @endif>{{ __('O+') }}</option>
                                                <option value="O-" @if (($medical_info && $medical_info->b_group == 'O-') || old('b_group') == 'O-') selected @endif>{{ __('O-') }}</option>
                                                <option value="AB+" @if (($medical_info && $medical_info->b_group == 'AB+') || old('b_group') == 'AB+') selected @endif>{{ __('AB+') }}</option>
                                                <option value="AB-" @if (($medical_info && $medical_info->b_group == 'AB-') || old('b_group') == 'AB-') selected @endif>{{ __('AB-') }}</option>
                                            </select>
                                            @error('b_group')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Pulso ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('pulse') is-invalid @enderror"
                                                tabindex="13" name="pulse" value="@if ($patient && $patient_info && $medical_info){{ old('pulse', $medical_info->pulse) }}@elseif(old('pulse')){{ old('pulse') }}@endif"
                                                id="patientPulse" placeholder="{{ __('Ingrese el pulso') }}">
                                            @error('pulse')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Alergia ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('allergy') is-invalid @enderror"
                                                tabindex="15" name="allergy" id="patientAllergy"
                                                value="@if ($patient && $patient_info && $medical_info){{ old('allergy', $medical_info->allergy) }}@elseif(old('allergy')){{ old('allergy') }}@endif"
                                                placeholder="{{ __('Ingrese los síntomas de alergia') }}">
                                            @error('allergy')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Peso ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('weight') is-invalid @enderror"
                                                tabindex="10" name="weight" id="patientWeight"
                                                value="@if ($patient && $patient_info && $medical_info){{ old('weight', $medical_info->weight) }}@elseif(old('weight')){{ old('weight') }}@endif" placeholder="{{ __('Ingrese el peso') }}">
                                            @error('weight')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Presión Arterial ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="tel"
                                                class="form-control @error('b_pressure') is-invalid @enderror"
                                                tabindex="12" name="b_pressure" id="blood_pressure"
                                                value="@if ($patient && $patient_info && $medical_info){{ old('b_pressure', $medical_info->b_pressure) }}@elseif(old('b_pressure')){{ old('b_pressure') }}@endif"
                                                placeholder="{{ __('Ingrese la presión arterial') }}">
                                            @error('b_pressure')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Respiración ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="tel"
                                                class="form-control @error('respiration') is-invalid @enderror"
                                                tabindex="14" name="respiration" id="patientRespiration"
                                                value="@if ($patient && $patient_info && $medical_info){{ old('respiration', $medical_info->respiration) }}@elseif(old('respiration')){{ old('respiration') }}@endif"
                                                placeholder="{{ __('Ingrese la respiración') }}">
                                            @error('respiration')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Dieta ') }}<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control @error('diet') is-invalid @enderror" tabindex="16"
                                                name="diet">
                                                <option selected disabled>{{ __('-- Seleccione Dieta --') }}</option>
                                                <option value="Vegetarian" @if (($medical_info && $medical_info->diet == 'Vegetarian') || old('diet') == 'Vegetarian') selected @endif>
                                                    {{ __('Vegetariana') }}</option>
                                                <option value="Non-vegetarian" @if (($medical_info && $medical_info->diet == 'Non-vegetarian') || old('diet') == 'Non-vegetarian') selected @endif>
                                                    {{ __('No vegetariana') }}</option>
                                                <option value="Vegan" @if (($medical_info && $medical_info->diet == 'Vegan') || old('diet') == 'Vegan') selected @endif>{{ __('Vegana') }}
                                                </option>
                                            </select>
                                            @error('diet')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <blockquote>{{ __('Antecedentes Médicos') }}</blockquote>
                                    <p class="text-muted mb-2">{{ __('Todos los campos de antecedentes médicos son opcionales.') }}</p>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('Diabetes') }} <span class="text-danger">*</span></label>
                                            <select class="form-control @error('diabetes_status') is-invalid @enderror" name="diabetes_status">
                                                <option disabled selected>{{ __('-- Seleccione --') }}</option>
                                                <option value="si" @if (($medical_info && $medical_info->diabetes_status == 'si') || old('diabetes_status') == 'si') selected @endif>Si</option>
                                                <option value="no" @if (($medical_info && $medical_info->diabetes_status == 'no') || old('diabetes_status') == 'no') selected @endif>No</option>
                                            </select>
                                            @error('diabetes_status')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('Diabetes controlado (si o no)') }}</label>
                                            <select class="form-control @error('diabetes_controlled') is-invalid @enderror" name="diabetes_controlled">
                                                <option value="">{{ __('-- Seleccione --') }}</option>
                                                <option value="si" @if (($medical_info && $medical_info->diabetes_controlled == 'si') || old('diabetes_controlled') == 'si') selected @endif>Si</option>
                                                <option value="no" @if (($medical_info && $medical_info->diabetes_controlled == 'no') || old('diabetes_controlled') == 'no') selected @endif>No</option>
                                            </select>
                                            @error('diabetes_controlled')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('Hipertensión') }} <span class="text-danger">*</span></label>
                                            <select class="form-control @error('hypertension_status') is-invalid @enderror" name="hypertension_status">
                                                <option disabled selected>{{ __('-- Seleccione --') }}</option>
                                                <option value="si" @if (($medical_info && $medical_info->hypertension_status == 'si') || old('hypertension_status') == 'si') selected @endif>Si</option>
                                                <option value="no" @if (($medical_info && $medical_info->hypertension_status == 'no') || old('hypertension_status') == 'no') selected @endif>No</option>
                                            </select>
                                            @error('hypertension_status')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('Hipertensión controlado (si o no)') }}</label>
                                            <select class="form-control @error('hypertension_controlled') is-invalid @enderror" name="hypertension_controlled">
                                                <option value="">{{ __('-- Seleccione --') }}</option>
                                                <option value="si" @if (($medical_info && $medical_info->hypertension_controlled == 'si') || old('hypertension_controlled') == 'si') selected @endif>Si</option>
                                                <option value="no" @if (($medical_info && $medical_info->hypertension_controlled == 'no') || old('hypertension_controlled') == 'no') selected @endif>No</option>
                                            </select>
                                            @error('hypertension_controlled')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('Actualmente embarazada') }} <span class="text-danger">*</span></label>
                                            <select class="form-control @error('currently_pregnant') is-invalid @enderror" name="currently_pregnant">
                                                <option disabled selected>{{ __('-- Seleccione --') }}</option>
                                                <option value="si" @if (($medical_info && $medical_info->currently_pregnant == 'si') || old('currently_pregnant') == 'si') selected @endif>Si</option>
                                                <option value="no" @if (($medical_info && $medical_info->currently_pregnant == 'no') || old('currently_pregnant') == 'no') selected @endif>No</option>
                                            </select>
                                            @error('currently_pregnant')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('Infarto') }} <span class="text-danger">*</span></label>
                                            <select class="form-control @error('heart_attack_history') is-invalid @enderror" name="heart_attack_history">
                                                <option disabled selected>{{ __('-- Seleccione --') }}</option>
                                                <option value="si" @if (($medical_info && $medical_info->heart_attack_history == 'si') || old('heart_attack_history') == 'si') selected @endif>Si</option>
                                                <option value="no" @if (($medical_info && $medical_info->heart_attack_history == 'no') || old('heart_attack_history') == 'no') selected @endif>No</option>
                                            </select>
                                            @error('heart_attack_history')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('¿Cuándo fue el último infarto?') }}</label>
                                            <input type="text" class="form-control @error('last_heart_attack') is-invalid @enderror"
                                                name="last_heart_attack" value="@if ($medical_info){{ old('last_heart_attack', $medical_info->last_heart_attack) }}@else{{ old('last_heart_attack') }}@endif"
                                                placeholder="{{ __('Ej: hace 2 años') }}">
                                            @error('last_heart_attack')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('Actualmente consume medicamentos') }} <span class="text-danger">*</span></label>
                                            <select class="form-control @error('takes_medications') is-invalid @enderror" name="takes_medications">
                                                <option disabled selected>{{ __('-- Seleccione --') }}</option>
                                                <option value="si" @if (($medical_info && $medical_info->takes_medications == 'si') || old('takes_medications') == 'si') selected @endif>Si</option>
                                                <option value="no" @if (($medical_info && $medical_info->takes_medications == 'no') || old('takes_medications') == 'no') selected @endif>No</option>
                                            </select>
                                            @error('takes_medications')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('¿Qué medicamentos utiliza?') }}</label>
                                            <textarea class="form-control @error('medications_list') is-invalid @enderror"
                                                name="medications_list" rows="3"
                                                placeholder="{{ __('Indique el nombre, dosis y frecuencia de cada medicamento') }}">@if ($medical_info){{ old('medications_list', $medical_info->medications_list) }}@else{{ old('medications_list') }}@endif</textarea>
                                            @error('medications_list')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('Ha consumido aspirina las últimas 72 horas') }} <span class="text-danger">*</span></label>
                                            <select class="form-control @error('aspirin_last_72h') is-invalid @enderror" name="aspirin_last_72h">
                                                <option disabled selected>{{ __('-- Seleccione --') }}</option>
                                                <option value="si" @if (($medical_info && $medical_info->aspirin_last_72h == 'si') || old('aspirin_last_72h') == 'si') selected @endif>Si</option>
                                                <option value="no" @if (($medical_info && $medical_info->aspirin_last_72h == 'no') || old('aspirin_last_72h') == 'no') selected @endif>No</option>
                                            </select>
                                            @error('aspirin_last_72h')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('Padece alguna enfermedad') }} <span class="text-danger">*</span></label>
                                            <select class="form-control @error('has_disease') is-invalid @enderror" name="has_disease">
                                                <option disabled selected>{{ __('-- Seleccione --') }}</option>
                                                <option value="si" @if (($medical_info && $medical_info->has_disease == 'si') || old('has_disease') == 'si') selected @endif>Si</option>
                                                <option value="no" @if (($medical_info && $medical_info->has_disease == 'no') || old('has_disease') == 'no') selected @endif>No</option>
                                            </select>
                                            @error('has_disease')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('¿Cuál enfermedad?') }}</label>
                                            <input type="text" class="form-control @error('disease_details') is-invalid @enderror"
                                                name="disease_details" value="@if ($medical_info){{ old('disease_details', $medical_info->disease_details) }}@else{{ old('disease_details') }}@endif"
                                                placeholder="{{ __('Describa la enfermedad') }}">
                                            @error('disease_details')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        @if ($patient && $patient_info && $medical_info)
                                            {{ __('Actualizar Datos del Paciente') }}
                                        @else
                                            {{ __('Agregar Nuevo Paciente') }}
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    @endsection
    @section('script')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var fieldsToHide = ['height', 'b_group', 'pulse', 'allergy', 'weight', 'b_pressure', 'respiration', 'diet'];

                fieldsToHide.forEach(function(fieldName) {
                    var field = document.querySelector('[name="' + fieldName + '"]');
                    if (field) {
                        field.disabled = true;
                        var wrapper = field.closest('.mb-3');
                        if (wrapper) {
                            wrapper.style.display = 'none';
                        }
                    }
                });

                var blockquotes = document.querySelectorAll('blockquote');
                blockquotes.forEach(function(bq) {
                    if (bq.textContent.trim() === 'Información Médica') {
                        bq.style.display = 'none';
                    }
                });
            });

            // Profile Photo
            function triggerClick() {
                document.querySelector('#profile_photo').click();
            }

            function displayProfile(e) {
                if (e.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        document.querySelector('#profile_display').setAttribute('src', e.target.result);
                    }
                    reader.readAsDataURL(e.files[0]);
                }
            }
        </script>
    @endsection

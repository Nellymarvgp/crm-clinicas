@extends('layouts.master-without-nav')
@section('title') {{ __('Complete Profile') }} @endsection

@section('css')
<style>
    .block-left .card {
        background: rgb(153 217 217);
        margin-bottom: 0;
        border-radius: 0;
        height: 100%;
        min-height: 570px; /* Ensure minimum height */
    }
    .account-pages .block-left .auth-logo .avatar-md.profile-user-wid {
        margin: 10px 0 !important;
        width: auto;
        height: auto;
    }
    .account-pages .block-left .auth-logo .avatar-md.profile-user-wid .avatar-title {
        display: block;
        background: transparent !important;
    }
    .account-pages .block-left .auth-logo .avatar-md.profile-user-wid .avatar-title img.rounded-circle {
        width: 50px;
        height: auto;
    }
    .account-pages .block-left .bg-light2 {
        background: #fff;
        margin: 20px;
        border: 1px solid #ccc;
        border-radius: 10px;
        padding: 2rem !important; /* Ensure padding matches register */
    }
    .account-pages .block-left .bg-light2 form button {
        background: rgb(153 217 217) !important;
        border: 1px solid rgb(153 217 217) !important;
        color: #fff; /* Ensure button text is visible */
    }
    .account-pages .justify-content-center {
        display: flex;
        align-items: stretch;
        flex-direction: row;
    }
    .account-pages .block-left, .account-pages .block-right {
        padding: 0;
        min-height: 570px;
    }
    .account-pages .block-right img {
        height: 100%;
        width: 100%;
        object-fit: cover;
    }
    .form-control:focus {
        border-color: rgb(153 217 217) !important;
        box-shadow: 0 0 0 0.15rem rgba(153, 217, 217, 0.25) !important;
    }
    /* Profile photo specific styles */
    #profile_display {
        display: block;
        width: 150px;  /* Adjust size as needed */
        height: 150px; /* Adjust size as needed */
        margin: 10px auto;
        border-radius: 50%;
        object-fit: cover;
        cursor: pointer;
        border: 3px solid #ddd;
    }
    /* MediaQueries */
    @media only screen and (max-width: 768px) {
        .account-pages .justify-content-center{
            display: block;
        }
        .account-pages .block-right {
            min-height: 300px;
        }
        .account-pages .block-left .card {
             min-height: auto;
        }
        .account-pages .block-left, .account-pages .block-right {
            min-height: auto;
        }
    }
    @media only screen and (max-width: 414px) {
        .account-pages {
            padding: 0 !important;
        }
    }
</style>
@endsection

@section('body')
    <body>
@endsection

@section('content')
    <div class="account-pages my-5 pt-5">
        <div class="container-fluid p-0"> <!-- Use container-fluid and remove padding -->
            <div class="row justify-content-center g-0"> <!-- Remove gutters -->
                <div class="col-md-6 col-lg-6 col-xs-12 block-left">
                    <div class="card overflow-hidden">
                        <div class="card-body pt-0">
                            <div class="auth-logo">
                                <a href="{{ url('/') }}" class="auth-logo-dark">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="{{ URL::asset('build/images/icon-plus.png') }}" alt="" class="rounded-circle" height="34">
                                        </span>
                                    </div>
                                </a>
                                <h5 class="text-center mt-0 text-white">{{ __('Complete su Perfil') }}</h5>
                                <p class="text-center text-white">Complete su cuenta {{ AppSetting('title') }}.</p>
                            </div>
                            <div class="p-4 bg-light2">
                                <form method="POST" class="form-horizontal mt-4" action="{{ url('user') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <blockquote>{{ __('Información Básica') }}</blockquote>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Edad ') }}<span
                                                        class="text-danger">*</span></label>
                                                <input type="number" min="1"
                                                    class="form-control @error('age') is-invalid @enderror" name="age"
                                                    id="patientAge" value="{{ old('age') }}"
                                                    placeholder="{{ __('Ingrese su Edad') }}">
                                                @error('age')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="formmessage">{{ __('Género ') }}<span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select @error('gender') is-invalid @enderror" name="gender">
                                                    <option value="" disabled {{ old('gender') ? '' : 'selected' }}>{{ __('-- Seleccione Género --') }}</option>
                                                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>{{ __('Masculino') }}</option>
                                                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>{{ __('Femenino') }}</option>
                                                    <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>{{ __('Otro') }}</option>
                                                </select>
                                                @error('gender')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Foto de Perfil ') }}<span
                                                        class="text-danger">*</span></label>
                                                <img class="@error('profile_photo') is-invalid @enderror"
                                                    src="{{ URL::asset('build/images/users/noImage.png') }}"
                                                    id="profile_display" onclick="triggerClick()" data-bs-toggle="tooltip"
                                                    data-placement="top" title="Click para subir foto de perfil" />
                                                <input type="file"
                                                    class="form-control @error('profile_photo') is-invalid @enderror"
                                                    name="profile_photo" id="profile_photo" style="display:none;"
                                                    onchange="displayProfile(this)" accept="image/*">
                                                @error('profile_photo')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                         <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Dirección Actual ') }}<span
                                                    class="text-danger">*</span></label>
                                            <textarea id="formmessage" name="address"
                                                class="form-control @error('address') is-invalid @enderror"
                                                 rows="3"
                                                placeholder="{{ __('Ingrese su Dirección Actual') }}">{{ old('address') }}</textarea>
                                            @error('address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <blockquote class="d-none">{{ __('Información Médica') }}</blockquote>
                                    <div class="row d-none">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Altura (cm)') }}<span class="text-danger">*</span></label>
                                                <input type="number" min="1" step="1"
                                                    class="form-control @error('height') is-invalid @enderror" name="height"
                                                    value="{{ old('height') }}"
                                                    placeholder="{{ __('Ingrese su altura en centímetros') }}">
                                                @error('height')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Peso (kg)') }}<span class="text-danger">*</span></label>
                                                <input type="number" min="1" step="0.1"
                                                    class="form-control @error('weight') is-invalid @enderror" name="weight"
                                                    value="{{ old('weight') }}"
                                                    placeholder="{{ __('Ingrese su peso en kilogramos') }}">
                                                @error('weight')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Grupo Sanguíneo') }}<span class="text-danger">*</span></label>
                                                <select class="form-select @error('b_group') is-invalid @enderror" name="b_group">
                                                    <option value="" disabled {{ old('b_group') ? '' : 'selected' }}>{{ __('-- Seleccione Grupo --') }}</option>
                                                    <option value="A+" {{ old('b_group') == 'A+' ? 'selected' : '' }}>A+</option>
                                                    <option value="A-" {{ old('b_group') == 'A-' ? 'selected' : '' }}>A-</option>
                                                    <option value="B+" {{ old('b_group') == 'B+' ? 'selected' : '' }}>B+</option>
                                                    <option value="B-" {{ old('b_group') == 'B-' ? 'selected' : '' }}>B-</option>
                                                    <option value="O+" {{ old('b_group') == 'O+' ? 'selected' : '' }}>O+</option>
                                                    <option value="O-" {{ old('b_group') == 'O-' ? 'selected' : '' }}>O-</option>
                                                    <option value="AB+" {{ old('b_group') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                                    <option value="AB-" {{ old('b_group') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                                </select>
                                                @error('b_group')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Pulso (bpm)') }}<span class="text-danger">*</span></label>
                                                <input type="number" min="1"
                                                    class="form-control @error('pulse') is-invalid @enderror" name="pulse"
                                                    value="{{ old('pulse') }}"
                                                    placeholder="{{ __('Ingrese su pulso') }}">
                                                @error('pulse')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Presión Arterial (mmHg)') }}<span class="text-danger">*</span></label>
                                                <input type="number" min="1"
                                                    class="form-control @error('b_pressure') is-invalid @enderror" name="b_pressure"
                                                    value="{{ old('b_pressure') }}"
                                                    placeholder="{{ __('Ingrese su presión arterial') }}">
                                                @error('b_pressure')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Respiración (rpm)') }}<span class="text-danger">*</span></label>
                                                <input type="number" min="1"
                                                    class="form-control @error('respiration') is-invalid @enderror" name="respiration"
                                                    value="{{ old('respiration') }}"
                                                    placeholder="{{ __('Ingrese su frecuencia respiratoria') }}">
                                                @error('respiration')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Alergias') }}<span class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('allergy') is-invalid @enderror" name="allergy"
                                                    value="{{ old('allergy') }}"
                                                    placeholder="{{ __('Ingrese sus alergias (solo letras)') }}">
                                                @error('allergy')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Dieta') }}<span class="text-danger">*</span></label>
                                                <textarea
                                                    class="form-control @error('diet') is-invalid @enderror" name="diet"
                                                    rows="3"
                                                    placeholder="{{ __('Describa su dieta actual') }}">{{ old('diet') }}</textarea>
                                                @error('diet')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <blockquote>{{ __('Antecedentes Médicos') }}</blockquote>
                                    <p class="text-muted mb-2">{{ __('Todos los campos de antecedentes médicos son opcionales.') }}</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Diabetes') }}<span class="text-danger">*</span></label>
                                                <select class="form-select @error('diabetes_status') is-invalid @enderror" name="diabetes_status">
                                                    <option value="" disabled {{ old('diabetes_status') ? '' : 'selected' }}>{{ __('-- Seleccione --') }}</option>
                                                    <option value="si" {{ old('diabetes_status') == 'si' ? 'selected' : '' }}>Si</option>
                                                    <option value="no" {{ old('diabetes_status') == 'no' ? 'selected' : '' }}>No</option>
                                                </select>
                                                @error('diabetes_status')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Diabetes controlado (si/no)') }}</label>
                                                <select class="form-select @error('diabetes_controlled') is-invalid @enderror" name="diabetes_controlled">
                                                    <option value="" selected>{{ __('-- Seleccione --') }}</option>
                                                    <option value="si" {{ old('diabetes_controlled') == 'si' ? 'selected' : '' }}>Si</option>
                                                    <option value="no" {{ old('diabetes_controlled') == 'no' ? 'selected' : '' }}>No</option>
                                                </select>
                                                @error('diabetes_controlled')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Hipertensión') }}<span class="text-danger">*</span></label>
                                                <select class="form-select @error('hypertension_status') is-invalid @enderror" name="hypertension_status">
                                                    <option value="" disabled {{ old('hypertension_status') ? '' : 'selected' }}>{{ __('-- Seleccione --') }}</option>
                                                    <option value="si" {{ old('hypertension_status') == 'si' ? 'selected' : '' }}>Si</option>
                                                    <option value="no" {{ old('hypertension_status') == 'no' ? 'selected' : '' }}>No</option>
                                                </select>
                                                @error('hypertension_status')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Hipertensión controlado (si/no)') }}</label>
                                                <select class="form-select @error('hypertension_controlled') is-invalid @enderror" name="hypertension_controlled">
                                                    <option value="" selected>{{ __('-- Seleccione --') }}</option>
                                                    <option value="si" {{ old('hypertension_controlled') == 'si' ? 'selected' : '' }}>Si</option>
                                                    <option value="no" {{ old('hypertension_controlled') == 'no' ? 'selected' : '' }}>No</option>
                                                </select>
                                                @error('hypertension_controlled')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Actualmente embarazada') }}<span class="text-danger">*</span></label>
                                                <select class="form-select @error('currently_pregnant') is-invalid @enderror" name="currently_pregnant">
                                                    <option value="" disabled {{ old('currently_pregnant') ? '' : 'selected' }}>{{ __('-- Seleccione --') }}</option>
                                                    <option value="si" {{ old('currently_pregnant') == 'si' ? 'selected' : '' }}>Si</option>
                                                    <option value="no" {{ old('currently_pregnant') == 'no' ? 'selected' : '' }}>No</option>
                                                </select>
                                                @error('currently_pregnant')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Infarto') }}<span class="text-danger">*</span></label>
                                                <select class="form-select @error('heart_attack_history') is-invalid @enderror" name="heart_attack_history">
                                                    <option value="" disabled {{ old('heart_attack_history') ? '' : 'selected' }}>{{ __('-- Seleccione --') }}</option>
                                                    <option value="si" {{ old('heart_attack_history') == 'si' ? 'selected' : '' }}>Si</option>
                                                    <option value="no" {{ old('heart_attack_history') == 'no' ? 'selected' : '' }}>No</option>
                                                </select>
                                                @error('heart_attack_history')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('¿Cuándo fue el último infarto?') }}</label>
                                                <input type="text" class="form-control @error('last_heart_attack') is-invalid @enderror"
                                                    name="last_heart_attack" value="{{ old('last_heart_attack') }}" placeholder="{{ __('Ej: hace 2 años') }}">
                                                @error('last_heart_attack')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Actualmente consume medicamentos') }}<span class="text-danger">*</span></label>
                                                <select class="form-select @error('takes_medications') is-invalid @enderror" name="takes_medications">
                                                    <option value="" disabled {{ old('takes_medications') ? '' : 'selected' }}>{{ __('-- Seleccione --') }}</option>
                                                    <option value="si" {{ old('takes_medications') == 'si' ? 'selected' : '' }}>Si</option>
                                                    <option value="no" {{ old('takes_medications') == 'no' ? 'selected' : '' }}>No</option>
                                                </select>
                                                @error('takes_medications')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('¿Cuál medicamentos?') }}</label>
                                                <input type="text" class="form-control @error('medications_list') is-invalid @enderror"
                                                    name="medications_list" value="{{ old('medications_list') }}" placeholder="{{ __('Describa los medicamentos') }}">
                                                @error('medications_list')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Aspirina en las últimas 72 horas') }}<span class="text-danger">*</span></label>
                                                <select class="form-select @error('aspirin_last_72h') is-invalid @enderror" name="aspirin_last_72h">
                                                    <option value="" disabled {{ old('aspirin_last_72h') ? '' : 'selected' }}>{{ __('-- Seleccione --') }}</option>
                                                    <option value="si" {{ old('aspirin_last_72h') == 'si' ? 'selected' : '' }}>Si</option>
                                                    <option value="no" {{ old('aspirin_last_72h') == 'no' ? 'selected' : '' }}>No</option>
                                                </select>
                                                @error('aspirin_last_72h')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Padece alguna enfermedad') }}<span class="text-danger">*</span></label>
                                                <select class="form-select @error('has_disease') is-invalid @enderror" name="has_disease">
                                                    <option value="" disabled {{ old('has_disease') ? '' : 'selected' }}>{{ __('-- Seleccione --') }}</option>
                                                    <option value="si" {{ old('has_disease') == 'si' ? 'selected' : '' }}>Si</option>
                                                    <option value="no" {{ old('has_disease') == 'no' ? 'selected' : '' }}>No</option>
                                                </select>
                                                @error('has_disease')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('¿Cuál?') }}</label>
                                                <input type="text" class="form-control @error('disease_details') is-invalid @enderror"
                                                    name="disease_details" value="{{ old('disease_details') }}" placeholder="{{ __('Describa la enfermedad') }}">
                                                @error('disease_details')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-center mt-4">
                                            <button type="submit"
                                                class="btn btn-primary w-md waves-effect waves-light">{{ __('Guardar Perfil') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xs-12 block-right d-none d-md-block"> <!-- Hide on small screens -->
                     <img src="{{ URL::asset('build/images/fondo-bg.png') }}" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Profile Photo Preview
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

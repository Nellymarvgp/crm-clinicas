@extends('layouts.master-layouts')
@section('title'){{ __('Update Patient') }}@endsection
    @section('content')
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">
                        {{ __('Update Patient Details') }}
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item active">
                                {{ __('Update Patient Details') }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <a href="{{ url('/dashboard') }}">
                    <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                        <i class="bx bx-arrow-back font-size-16 align-middle me-2"></i>{{ __('Back to Dashboard') }}
                    </button>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <blockquote>{{ __('Basic Information') }}</blockquote>
                        <form action="{{ url('profile-update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('First Name ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('first_name') is-invalid @enderror"
                                                name="first_name" id="FirstName" tabindex="1"
                                                value="@if ($patient){{ old('first_name', $patient->first_name) }}@elseif(old('first_name')){{ old('first_name') }}@endif"
                                                placeholder="{{ __('Enter First Name') }}">
                                            @error('first_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-md-12">
                                            <label for="formmessage">{{ __('Gender ') }}<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control @error('gender') is-invalid @enderror" tabindex="3"
                                                name="gender">
                                                <option selected disabled>{{ __('-- Select Gender --') }}</option>
                                                <option value="Male" @if (($patient_info && $patient_info->gender == 'Male') || old('gender') == 'Male') selected @endif>{{ __('Male') }}</option>
                                                <option value="Female" @if (($patient_info && $patient_info->gender == 'Female') || old('gender') == 'Female') selected @endif>{{ __('Female') }}
                                                </option>
                                                <option value="Other" @if (($patient_info && $patient_info->gender == 'Other') || old('gender') == 'Other') selected @endif>{{ __('Other') }}</option>
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
                                            <label class="form-label">{{ __('Email ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                tabindex="5" name="email" id="patientEmail" value="@if ($patient){{ old('email', $patient->email) }}@elseif(old('email')){{ old('email') }}@endif"
                                                placeholder="{{ __('Enter Email') }}">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Current Address ') }}<span
                                                    class="text-danger">*</span></label>
                                            <textarea id="formmessage" name="address" tabindex="7"
                                                class="form-control @error('address') is-invalid @enderror" rows="3"
                                                placeholder="{{ __('Enter Current Address') }}">@if ($patient && $patient_info){{ $patient_info->address }}@elseif(old('address')){{ old('address') }}@endif</textarea>
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
                                            <label class="form-label">{{ __('Last Name ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                                tabindex="2" name="last_name" id="LastName" value="@if ($patient){{ old('last_name', $patient->last_name) }}@elseif(old('last_name')){{ old('last_name') }}@endif"
                                                placeholder="{{ __('Enter Last Name') }}">
                                            @error('last_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Age ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('age') is-invalid @enderror"
                                                tabindex="4" name="age" id="patientAge" value="@if ($patient && $patient_info ){{ old('age', $patient_info->age) }}@elseif(old('age')){{ old('age') }}@endif"
                                                placeholder="{{ __('Enter Age') }}">
                                            @error('age')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Contact Number ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="tel" class="form-control @error('mobile') is-invalid @enderror"
                                                tabindex="6" name="mobile" id="patientMobile"
                                                value="@if ($patient){{ old('mobile', $patient->mobile) }}@elseif(old('mobile')){{ old('mobile') }}@endif"
                                                placeholder="{{ __('Enter Contact Number') }}">
                                            @error('mobile')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Profile Photo ') }}</label>
                                            <img class="@error('profile_photo') is-invalid @enderror "
                                                src="@if ($patient && $patient->profile_photo != null){{ URL::asset('storage/images/users/' . $patient->profile_photo) }}@else{{ URL::asset('build/images/users/noImage.png') }}@endif" onclick="triggerClick()"
                                                data-bs-toggle="tooltip" data-placement="top"
                                                title="Click to Upload Profile Photo" id="profile_display" />
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
                            <blockquote>{{ __('Medical Information') }}</blockquote>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Height ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('height') is-invalid @enderror"
                                                name="height" tabindex="9" value="@if ($patient && $patient_info && $medical_info){{ old('height', $medical_info->height) }}@elseif(old('height')){{ old('height') }}@endif"
                                                id="patientHeight" placeholder="{{ __('Enter Height In Centimeter') }}">
                                            @error('height')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-md-12">
                                            <label for="formmessage">{{ __('Blood Group ') }}<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control @error('b_group') is-invalid @enderror"
                                                tabindex="11" name="b_group">
                                                <option selected disabled>{{ __('-- Select Blood Group --') }}</option>
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
                                            <label class="form-label">{{ __('Pulse ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('pulse') is-invalid @enderror"
                                                tabindex="13" name="pulse" value="@if ($patient && $patient_info && $medical_info){{ old('pulse', $medical_info->pulse) }}@elseif(old('pulse')){{ old('pulse') }}@endif"
                                                id="patientPulse" placeholder="{{ __('Enter Pulse') }}">
                                            @error('pulse')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Allergy ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('allergy') is-invalid @enderror"
                                                tabindex="15" name="allergy" id="patientAllergy"
                                                value="@if ($patient && $patient_info && $medical_info){{ old('allergy', $medical_info->allergy) }}@elseif(old('allergy')){{ old('allergy') }}@endif"
                                                placeholder="{{ __('Enter Allergy Symptoms') }}">
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
                                            <label class="form-label">{{ __('Weight ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('weight') is-invalid @enderror"
                                                tabindex="10" name="weight" id="patientWeight"
                                                value="@if ($patient && $patient_info && $medical_info){{ old('weight', $medical_info->weight) }}@elseif(old('weight')){{ old('weight') }}@endif" placeholder="{{ __('Enter Weight') }}">
                                            @error('weight')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Blood Pressure ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="tel"
                                                class="form-control @error('b_pressure') is-invalid @enderror"
                                                tabindex="12" name="b_pressure" id="blood_pressure"
                                                value="@if ($patient && $patient_info && $medical_info){{ old('b_pressure', $medical_info->b_pressure) }}@elseif(old('b_pressure')){{ old('b_pressure') }}@endif"
                                                placeholder="{{ __('Enter Blood Pressure') }}">
                                            @error('b_pressure')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Respiration ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="tel"
                                                class="form-control @error('respiration') is-invalid @enderror"
                                                tabindex="14" name="respiration" id="patientRespiration"
                                                value="@if ($patient && $patient_info && $medical_info){{ old('respiration', $medical_info->respiration) }}@elseif(old('respiration')){{ old('respiration') }}@endif"
                                                placeholder="{{ __('Enter Respiration') }}">
                                            @error('respiration')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Diet ') }}<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control @error('diet') is-invalid @enderror" tabindex="16"
                                                name="diet">
                                                <option selected disabled>{{ __('-- Select Diet --') }}</option>
                                                <option value="Vegetarian" @if (($medical_info && $medical_info->diet == 'Vegetarian') || old('diet') == 'Vegetarian') selected @endif>
                                                    {{ __('Vegetarian') }}</option>
                                                <option value="Non-vegetarian" @if (($medical_info && $medical_info->diet == 'Non-vegetarian') || old('diet') == 'Non-vegetarian') selected @endif>
                                                    {{ __('Non-vegetarian') }}</option>
                                                <option value="Vegan" @if (($medical_info && $medical_info->diet == 'Vegan') || old('diet') == 'Vegan') selected @endif>{{ __('Vegan') }}
                                                </option>
                                            </select>
                                            @error('diet')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="d-none">
                                    <blockquote>{{ __('Medical History') }}</blockquote>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Diabetes') }} <span class="text-danger">*</span></label>
                                            <select class="form-control @error('diabetes_status') is-invalid @enderror" name="diabetes_status">
                                                <option disabled selected>{{ __('-- Select --') }}</option>
                                                <option value="si" @if (($medical_info && $medical_info->diabetes_status == 'si') || old('diabetes_status') == 'si') selected @endif>Yes</option>
                                                <option value="no" @if (($medical_info && $medical_info->diabetes_status == 'no') || old('diabetes_status') == 'no') selected @endif>No</option>
                                            </select>
                                            @error('diabetes_status')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Diabetes controlled (yes/no)') }}</label>
                                            <select class="form-control @error('diabetes_controlled') is-invalid @enderror" name="diabetes_controlled">
                                                <option value="">{{ __('-- Select --') }}</option>
                                                <option value="si" @if (($medical_info && $medical_info->diabetes_controlled == 'si') || old('diabetes_controlled') == 'si') selected @endif>Yes</option>
                                                <option value="no" @if (($medical_info && $medical_info->diabetes_controlled == 'no') || old('diabetes_controlled') == 'no') selected @endif>No</option>
                                            </select>
                                            @error('diabetes_controlled')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Hypertension') }} <span class="text-danger">*</span></label>
                                            <select class="form-control @error('hypertension_status') is-invalid @enderror" name="hypertension_status">
                                                <option disabled selected>{{ __('-- Select --') }}</option>
                                                <option value="si" @if (($medical_info && $medical_info->hypertension_status == 'si') || old('hypertension_status') == 'si') selected @endif>Yes</option>
                                                <option value="no" @if (($medical_info && $medical_info->hypertension_status == 'no') || old('hypertension_status') == 'no') selected @endif>No</option>
                                            </select>
                                            @error('hypertension_status')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Hypertension controlled (yes/no)') }}</label>
                                            <select class="form-control @error('hypertension_controlled') is-invalid @enderror" name="hypertension_controlled">
                                                <option value="">{{ __('-- Select --') }}</option>
                                                <option value="si" @if (($medical_info && $medical_info->hypertension_controlled == 'si') || old('hypertension_controlled') == 'si') selected @endif>Yes</option>
                                                <option value="no" @if (($medical_info && $medical_info->hypertension_controlled == 'no') || old('hypertension_controlled') == 'no') selected @endif>No</option>
                                            </select>
                                            @error('hypertension_controlled')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Currently pregnant') }} <span class="text-danger">*</span></label>
                                            <select class="form-control @error('currently_pregnant') is-invalid @enderror" name="currently_pregnant">
                                                <option disabled selected>{{ __('-- Select --') }}</option>
                                                <option value="si" @if (($medical_info && $medical_info->currently_pregnant == 'si') || old('currently_pregnant') == 'si') selected @endif>Yes</option>
                                                <option value="no" @if (($medical_info && $medical_info->currently_pregnant == 'no') || old('currently_pregnant') == 'no') selected @endif>No</option>
                                            </select>
                                            @error('currently_pregnant')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Heart attack history') }} <span class="text-danger">*</span></label>
                                            <select class="form-control @error('heart_attack_history') is-invalid @enderror" name="heart_attack_history">
                                                <option disabled selected>{{ __('-- Select --') }}</option>
                                                <option value="si" @if (($medical_info && $medical_info->heart_attack_history == 'si') || old('heart_attack_history') == 'si') selected @endif>Yes</option>
                                                <option value="no" @if (($medical_info && $medical_info->heart_attack_history == 'no') || old('heart_attack_history') == 'no') selected @endif>No</option>
                                            </select>
                                            @error('heart_attack_history')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('When was the last heart attack?') }}</label>
                                            <input type="text" class="form-control @error('last_heart_attack') is-invalid @enderror"
                                                name="last_heart_attack" value="@if ($medical_info){{ old('last_heart_attack', $medical_info->last_heart_attack) }}@else{{ old('last_heart_attack') }}@endif"
                                                placeholder="{{ __('Example: 2 years ago') }}">
                                            @error('last_heart_attack')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Currently taking medications') }} <span class="text-danger">*</span></label>
                                            <select class="form-control @error('takes_medications') is-invalid @enderror" name="takes_medications">
                                                <option disabled selected>{{ __('-- Select --') }}</option>
                                                <option value="si" @if (($medical_info && $medical_info->takes_medications == 'si') || old('takes_medications') == 'si') selected @endif>Yes</option>
                                                <option value="no" @if (($medical_info && $medical_info->takes_medications == 'no') || old('takes_medications') == 'no') selected @endif>No</option>
                                            </select>
                                            @error('takes_medications')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Which medications?') }}</label>
                                            <input type="text" class="form-control @error('medications_list') is-invalid @enderror"
                                                name="medications_list" value="@if ($medical_info){{ old('medications_list', $medical_info->medications_list) }}@else{{ old('medications_list') }}@endif"
                                                placeholder="{{ __('Describe medications') }}">
                                            @error('medications_list')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Aspirin in the last 72 hours') }} <span class="text-danger">*</span></label>
                                            <select class="form-control @error('aspirin_last_72h') is-invalid @enderror" name="aspirin_last_72h">
                                                <option disabled selected>{{ __('-- Select --') }}</option>
                                                <option value="si" @if (($medical_info && $medical_info->aspirin_last_72h == 'si') || old('aspirin_last_72h') == 'si') selected @endif>Yes</option>
                                                <option value="no" @if (($medical_info && $medical_info->aspirin_last_72h == 'no') || old('aspirin_last_72h') == 'no') selected @endif>No</option>
                                            </select>
                                            @error('aspirin_last_72h')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Do you have any disease?') }} <span class="text-danger">*</span></label>
                                            <select class="form-control @error('has_disease') is-invalid @enderror" name="has_disease">
                                                <option disabled selected>{{ __('-- Select --') }}</option>
                                                <option value="si" @if (($medical_info && $medical_info->has_disease == 'si') || old('has_disease') == 'si') selected @endif>Yes</option>
                                                <option value="no" @if (($medical_info && $medical_info->has_disease == 'no') || old('has_disease') == 'no') selected @endif>No</option>
                                            </select>
                                            @error('has_disease')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Which disease?') }}</label>
                                            <input type="text" class="form-control @error('disease_details') is-invalid @enderror"
                                                name="disease_details" value="@if ($medical_info){{ old('disease_details', $medical_info->disease_details) }}@else{{ old('disease_details') }}@endif"
                                                placeholder="{{ __('Describe the disease') }}">
                                            @error('disease_details')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                    </div>
                                </div>
                                    </div>
                                    </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update  Details') }}
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

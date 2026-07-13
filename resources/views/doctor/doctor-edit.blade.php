@extends('layouts.master-layouts')
@section('title')
    {{ __('Actualizar datos del doctor') }}
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}">
@endsection
    @section('content')
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">
                        {{ __('Actualizar datos del doctor') }}
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('doctor') }}">{{ __('Doctores') }}</a></li>
                            <li class="breadcrumb-item active">
                                {{ __('Actualizar datos del doctor') }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                @if ($doctor && $doctor_info)
                    @if ($role == 'doctor')
                        <a href="{{ url('/dashboard') }}">
                            <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                                <i
                                    class="bx bx-arrow-back font-size-16 align-middle me-2"></i>{{ __('Volver al panel') }}
                            </button>
                        </a>
                    @else
                        <a href="{{ url('doctor/' . $doctor->id) }}">
                            <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                                <i
                                    class="bx bx-arrow-back font-size-16 align-middle me-2"></i>{{ __('Volver al perfil') }}
                            </button>
                        </a>
                    @endif
                @else
                    <a href="{{ url('doctor') }}">
                        <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                            <i
                                class="bx bx-arrow-back font-size-16 align-middle me-2"></i>{{ __('Volver a la lista de doctores') }}
                        </button>
                    </a>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <blockquote>{{ __('Informacion basica') }}</blockquote>
                        <form action="{{ url('doctor/' . $doctor->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @if ($doctor && $doctor_info)
                                <input type="hidden" name="_method" value="PATCH" />
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                                <label class="form-label">{{ __('Nombre ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('first_name') is-invalid @enderror"
                                                name="first_name" id="firstname" tabindex="1"
                                                value="{{ old('first_name', $doctor->first_name) }}"
                                                placeholder="{{ __('Ingrese el nombre') }}">
                                            @error('first_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                                <label class="form-label">{{ __('Correo electronico ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                name="email" id="email" tabindex="3"
                                                value="{{ old('email', $doctor->email) }}"
                                                placeholder="{{ __('Ingrese el correo electronico') }}">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                                <label class="form-label">{{ __('Titulo profesional ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                                name="title" id="title" tabindex="5"
                                                value="{{ old('title', $doctor_info->title) }}"
                                                placeholder="{{ __('Ingrese el titulo profesional') }}">
                                            @error('title')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                                <label class="form-label">{{ __('Departamento') }}<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control select2 @error('department') is-invalid @enderror"
                                                name="department" id="department">
                                                <option value="" disabled selected>Seleccione departamento</option>
                                                @foreach ($departments as $department)
                                                <option value="{{ $department->id }}"
                                                    {{ $doctor_info->department_id == $department->id ? 'selected' : '' }}>
                                                    {{ $department->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('department')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                                <label class="form-label">{{ __('Experiencia ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('experience') is-invalid @enderror"
                                                name="experience" tabindex="7" id="experience"
                                                value="{{ old('experience', $doctor_info->experience) }}"
                                                placeholder="{{ __('Ingrese la experiencia') }}">
                                            @error('experience')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        @if ($availableDay)
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label d-block">{{ __('Dias de atencion del doctor') }} <span
                                                        class="text-danger">*</span></label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1"
                                                        value="1" name="sun" {{ $availableDay->sun == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="inlineCheckbox1">Dom</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2"
                                                        value="1" name="mon" {{ $availableDay->mon == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="inlineCheckbox2">Lun</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox3"
                                                        value="1" name="tue" {{ $availableDay->tue == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="inlineCheckbox3">Mar</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox4"
                                                        value="1" name="wen" {{ $availableDay->wen == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="inlineCheckbox4">Mie</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox5"
                                                        value="1" name="thu" {{ $availableDay->thu == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="inlineCheckbox5">Jue</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox6"
                                                        value="1" name="fri" {{ $availableDay->fri == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="inlineCheckbox6">Vie</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox7"
                                                        value="1" name="sat" {{ $availableDay->sat == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="inlineCheckbox7">Sab</label>
                                                </div>
                                                @error('mon')
                                                    <span class="error d-block " role="alert">
                                                        <strong>Seleccione al menos un dia</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        @endif
                                    </div>
                                    @if ($availableTime && $availableTime->count() > 0)
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label d-block">Rangos de horario actuales</label>
                                                <div class="border rounded p-2 bg-light">
                                                    @foreach ($availableTime as $timeRange)
                                                        <div class="small text-muted">{{ \Carbon\Carbon::parse($timeRange->from)->format('H:i') }} - {{ \Carbon\Carbon::parse($timeRange->to)->format('H:i') }}</div>
                                                    @endforeach
                                                </div>
                                                <small class="form-text text-muted">Para modificar los rangos de horas use el boton "Editar horarios".</small>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <a href="{{ url('time-edit/' . $doctor->id) }}" class="btn btn-outline-primary">Editar horarios</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                                <label class="form-label">{{ __('Apellido ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                                name="last_name" id="lastname" tabindex="2"
                                                value="{{ old('last_name', $doctor->last_name) }}"
                                                placeholder="{{ __('Ingrese el apellido') }}">
                                            @error('last_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                                <label class="form-label">{{ __('Telefono ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="tel" class="form-control @error('mobile') is-invalid @enderror"
                                                name="mobile" id="patientMobile" tabindex="4"
                                                value="{{ old('mobile', $doctor->mobile) }}"
                                                placeholder="{{ __('Ingrese el telefono') }}">
                                            @error('mobile')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                                <label class="form-label">{{ __('Titulacion ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('degree') is-invalid @enderror"
                                                name="degree" id="degree" tabindex="6"
                                                value="{{ old('degree', $doctor_info->degree) }}"
                                                placeholder="{{ __('Ingrese la titulacion') }}">
                                            @error('degree')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                                <label class="form-label">{{ __('Honorarios ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('fees') is-invalid @enderror"
                                                name="fees" id="fees" tabindex="6"
                                                value="{{ old('fees', $doctor_info->fees) }}"
                                                placeholder="{{ __('Ingrese los honorarios') }}">
                                            @error('fees')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">{{ __('Foto de perfil ') }}</label>
                                            <img class="@error('profile_photo') is-invalid @enderror"
                                                src=" @if ($doctor && $doctor_info &&
                                                $doctor->profile_photo != null)
                                            {{ URL::asset('storage/images/users/' . $doctor->profile_photo) }}
                                        @else {{ URL::asset('build/images/users/noImage.png') }} @endif"
                                            id="profile_display" onclick="triggerClick()"
                                            data-bs-toggle="tooltip" data-placement="top"
                                            title="Haga clic para cargar la foto de perfil" />
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
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        @if ($doctor && $doctor_info)
                                            {{ __('Actualizar datos') }}
                                        @else
                                            {{ __('Crear doctor') }}
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
        <script src="{{ URL::asset('build/libs/jquery-repeater/jquery-repeater.min.js') }}"></script>
        <!-- form init -->
        <script src="{{ URL::asset('build/js/pages/form-repeater.int.js') }}"></script>
        <script src="{{ URL::asset('build/libs/select2/js/select2.min.js') }}"></script>
        <script src="{{ URL::asset('build/js/pages/form-advanced.init.js') }}"></script>
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
            // Checkbox value check
            $('#inlineCheckbox1').on('change', function() {
                var inlineCheckbox1 = $('#inlineCheckbox1').is(':checked') ? '1' : '0';
                $('#inlineCheckbox1').val(inlineCheckbox1);
            }).change();
            $('#inlineCheckbox2').on('change', function() {
                var inlineCheckbox2 = $('#inlineCheckbox2').is(':checked') ? '1' : '0';
                $('#inlineCheckbox2').val(inlineCheckbox2);
            }).change();
            $('#inlineCheckbox3').on('change', function() {
                var inlineCheckbox3 = $('#inlineCheckbox3').is(':checked') ? '1' : '0';
                $('#inlineCheckbox3').val(inlineCheckbox3);
            }).change();
            $('#inlineCheckbox4').on('change', function() {
                var inlineCheckbox4 = $('#inlineCheckbox4').is(':checked') ? '1' : '0';
                $('#inlineCheckbox4').val(inlineCheckbox4);
            }).change();
            $('#inlineCheckbox5').on('change', function() {
                var inlineCheckbox5 = $('#inlineCheckbox5').is(':checked') ? '1' : '0';
                $('#inlineCheckbox5').val(inlineCheckbox5);
            }).change();
            $('#inlineCheckbox6').on('change', function() {
                var inlineCheckbox6 = $('#inlineCheckbox6').is(':checked') ? '1' : '0';
                $('#inlineCheckbox6').val(inlineCheckbox6);
            }).change();
            $('#inlineCheckbox7').on('change', function() {
                var inlineCheckbox7 = $('#inlineCheckbox7').is(':checked') ? '1' : '0';
                $('#inlineCheckbox7').val(inlineCheckbox7);
            }).change();
        </script>
    @endsection

@extends('layouts.master-without-nav')
@section('title') {{ __("Iniciar Sesión") }} @endsection
@section('css')
<style>
    :root {
        --core-sand: #d1cba4;
        --core-stone: #7c7c7b;
        --core-deep: #666665;
        --core-soft: #f6f3e8;
    }

    .block-left .card {
        background: var(--core-sand);
        margin-bottom: 0;
        border-radius: 0;
        height: 100%;
    }
    .account-pages .block-left .auth-logo .avatar-md.profile-user-wid {
        margin: 10px 0 !important;
        width: auto;
        height: auto;
    }
    .account-pages .block-left .auth-logo .avatar-md.profile-user-wid .avatar-title {
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent !important;
    }
    .account-pages .block-left .auth-logo .avatar-md.profile-user-wid .avatar-title i {
        font-size: 34px;
        color: var(--core-stone);
    }
    .account-pages .block-left .bg-light2 {
        background: #fff;
        margin: 20px;
        border: 1px solid rgba(124, 124, 123, 0.3);
        border-radius: 10px;
    }
    .account-pages .block-left .bg-light2 form button {
        background: var(--core-stone) !important;
        border: 1px solid var(--core-stone) !important;
        color: #fff !important;
    }
    .account-pages .block-left .bg-light2 form button:hover,
    .account-pages .block-left .bg-light2 form button:focus {
        background: var(--core-deep) !important;
        border-color: var(--core-deep) !important;
    }
    .account-pages .block-left .bg-light2 form .mt-4.text-center a.text-muted {
        margin-bottom: 20px;
        display: block;
        border-bottom: 1px solid #ccc;
        padding-bottom: 20px;
    }
    .account-pages .block-left .bg-light2 form .mt-4.text-center p {
        margin: 0;
    }
    .account-pages .block-left .bg-light2 form .mt-4.text-center p a.fw-medium.text-primary {
        color: var(--core-stone) !important;
        text-decoration: underline;
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

    .account-pages label,
    .account-pages .form-check-label,
    .account-pages .text-muted,
    .account-pages p {
        color: var(--core-stone) !important;
    }

    .account-pages .form-control:focus {
        border-color: var(--core-sand);
        box-shadow: 0 0 0 0.2rem rgba(209, 203, 164, 0.25);
    }

    /* MediaQueries */
    @media only screen and (max-width: 768px) {
        .account-pages .justify-content-center{
            display: block;
        }
    }
    @media only screen and (max-width: 414px) {
        .account-pages {
            padding: 0 !important;
        }
        .block-right img {
            width: 100%;
            height: auto;
        }
    }
</style>
@endsection
@section('body')
<body>
@endsection
@section('content')
    <div class="account-pages my-5 pt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-6 col-xs-12 block-left">
                    <div class="card overflow-hidden">
                        <div class="card-body pt-0">
                            <div class="auth-logo">
                                <a href="{{ url('/panel') }}" class="auth-logo-dark">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <i class="fas fa-tooth" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="p-5 bg-light2">
                                <form class="form-horizontal" method="POST" action="{{ url('login') }}">
                                    @csrf
                                    @if ($msg = Session::get('error'))
                                        <div class="alert alert-danger">
                                            <span> {{ $msg }} </span>
                                        </div>
                                    @endif
                                    @if ($msg = Session::get('success'))
                                        <div class="alert alert-success">
                                            <span> {{ $msg }} </span>
                                        </div>
                                    @endif
                                    <div class="mb-3">
                                        <label for="username">{{ __("Correo electrónico") }} <span class="text-danger">*</span></label>
                                        <input name="email" type="email" id="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            @if (old('email')) value="{{ old('email') }}" @endif id="username" placeholder="Ingrese su correo electrónico"
                                            autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="userpassword">{{ __("Contraseña") }} <span class="text-danger">*</span></label>
                                        <input type="password" name="password" id="pass"
                                            class="form-control  @error('password') is-invalid @enderror"
                                            id="userpassword" @if (old('password')) value="{{ old('password') }}" @endif placeholder="Ingrese su contraseña">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="remember"
                                            id="customControlInline">
                                        <label class="form-check-label" for="customControlInline">Recuérdame</label>
                                    </div>
                                    <div class="mt-3">
                                        <button class="btn btn-primary w-100 waves-effect waves-light"
                                            type="submit">{{ __("Iniciar Sesión") }}</button>
                                    </div>
                                    <div class="mt-4 text-center">
                                        <a href="{{ url('forgot-password') }}" class="text-muted"><i
                                                class="mdi mdi-lock me-1"></i> {{ __("¿Olvidó su contraseña?") }}</a>
                                                <p>{{ __("¿No tiene una cuenta?") }} <a href="{{ url('register') }}"
                                class="fw-medium text-primary"> {{ __("Regístrese aquí") }}</a> </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xs-12 block-right">
                    <img src="{{ URL::asset('build/images/fondo-od.jpg') }}" alt="Imagen odontologica" class="image-bg">
                </div>
            </div>
        </div>
    </div>
    <script>
    </script>
@endsection

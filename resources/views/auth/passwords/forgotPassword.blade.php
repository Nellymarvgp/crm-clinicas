@extends('layouts.master-without-nav')

@section('title') {{ __("Recuperar Contraseña") }} @endsection

@section('css')
<style>
    :root {
        --core-sand: #d1cba4;
        --core-stone: #7c7c7b;
        --core-deep: #666665;
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
    .form-control:focus {
        border-color: var(--core-sand) !important;
        box-shadow: 0 0 0 0.15rem rgba(209, 203, 164, 0.28) !important;
    }

    .account-pages label,
    .account-pages p,
    .account-pages .text-muted {
        color: var(--core-stone) !important;
    }
    /* MediaQueries */
    @media only screen and (max-width: 768px) {
        .account-pages .justify-content-center{
            display: block;
        }
        .account-pages .block-right {
            min-height: 300px;
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
                            <div class="p-4 bg-light2">
                                <div class="text-center mb-4">
                                    <h4 class="text-muted">{{ __("¿Olvidaste tu contraseña?") }}</h4>
                                    <p class="text-muted">{{ __("Ingresa tu email y te enviaremos las instrucciones para restablecerla.") }}</p>
                                </div>
                                <form class="form-horizontal" method="POST" action="{{ url('forgot-password') }}">
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
                                        <label for="username">{{ __("Email") }} <span class="text-danger">*</span></label>
                                        <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                            @if (old('email')) value="{{ old('email') }}" @endif 
                                            id="username" placeholder="{{ __("Ingresa tu email") }}" 
                                            autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mt-4 text-center">
                                        <button class="btn btn-primary w-md waves-effect waves-light"
                                            type="submit">{{ __("Enviar instrucciones") }}</button>
                                    </div>
                                    <div class="mt-4 text-center">
                                        <p>{{ __("¿Recordaste tu contraseña?") }} <a href="{{ url('login') }}"
                                                class="fw-medium text-primary">{{ __("Iniciar Sesión") }}</a></p>
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
@endsection

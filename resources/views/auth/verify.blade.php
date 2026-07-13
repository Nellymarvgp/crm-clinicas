@extends('layouts.master-without-nav')

@section('title') {{ __("Reset Password") }} @endsection

@section('css')
<style>
    :root {
        --core-sand: #d1cba4;
        --core-stone: #7c7c7b;
        --core-deep: #666665;
    }

    .bg-primary-subtle {
        background: rgba(209, 203, 164, 0.2) !important;
    }

    .text-primary,
    .text-primary h5,
    h5.text-primary {
        color: var(--core-stone) !important;
    }

    .auth-logo .avatar-title {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .auth-logo .avatar-title i {
        color: var(--core-stone);
        font-size: 30px;
    }

    .btn-primary {
        background: var(--core-stone) !important;
        border-color: var(--core-stone) !important;
        color: #fff !important;
    }

    .btn-primary:hover,
    .btn-primary:focus {
        background: var(--core-deep) !important;
        border-color: var(--core-deep) !important;
    }

    .form-control:focus {
        border-color: var(--core-sand) !important;
        box-shadow: 0 0 0 0.15rem rgba(209, 203, 164, 0.28) !important;
    }
</style>
@endsection

@section('body')
<body>
@endsection

@section('content')
    <div class="home-btn d-none d-sm-block">
        <a href="{{ url('/dashboard') }}" class="text-dark"><i class="fas fa-home h2"></i></a>
    </div>
    <div class="account-pages my-5 pt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-primary-subtle">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">{{ __("Reset Password") }}</h5>
                                        <p>Restablece tu contraseña con {{ AppSetting('title'); }}.</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="{{ URL::asset('build/images/servicio3.png') }}" alt="Odontologia" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="auth-logo">
                                <a href="{{ url('/dashboard') }}" class="auth-logo-light">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <i class="fas fa-tooth" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </a>
                                <a href="{{ url('/dashboard') }}" class="auth-logo-dark">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <i class="fas fa-tooth" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2">
                                <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="username">{{ __("Username") }}</label>
                                        <input name="email" type="email"  class="form-control @error('email') is-invalid @enderror"
                                            @if (old('email')) value="{{ old('email') }}" @endif id="username" placeholder="{{ __("Enter username") }}"
                                            autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3 row mb-0">
                                        <div class="col-12 text-end">
                                            <button class="btn btn-primary w-md waves-effect waves-light"
                                                type="submit">{{ __("Reset") }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <p>{{ __("Remember It?") }} <a href="{{ url('login') }}" class="fw-medium text-primary"> {{ __("Sign In here") }}</a></p>
                        <p>© {{ date('Y') }} {{ AppSetting('title'); }}. {{ __('por CORE') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

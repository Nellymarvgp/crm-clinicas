@extends('layouts.master-without-nav')

@section('title') {{ __("Welcome Email For Default Credentials") }} @endsection

@section('body')
<body>
@endsection

@section('content')
    <div class="account-pages my-5 pt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-primary-subtle">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">{{ AppSetting('title'); }} - Sistema de gestión odontológica</h5>
                                        <p>Aquí tienes las credenciales de acceso para {{ AppSetting('title'); }}.</p>
                                    </div>
                                </div>
                                <!-- <div class="col-5 align-self-end">
                                    <img src="{{ URL::asset('build/images/profile-img.png') }}" alt="" class="img-fluid">
                                </div> -->
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div>
                                <a href="{{ url('/dashboard') }}" class="auth-logo-light">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="{{ URL::asset('build/images/logo-dark.png') }}" alt=""
                                                class="rounded-circle" height="34">
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2">
                                <h4>{{ __("Hello,") }} {{ $user->first_name }} {{ $user->last_name }}</h4>
                                <p>Las credenciales por defecto de tu cuenta son las siguientes:</p>
                                <p><b>Usuario:</b> {{ $user->email }}</p>
                                <p><b>Contraseña:</b> {{ config('app.DEFAULT_PASSWORD'); }}</p>
                                <p>Puedes cambiar la contraseña luego de iniciar sesión desde tu perfil.</p>
                                <p>Gracias,</p>
                                <p>{{ AppSetting('title'); }}.</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <p>© {{ date('Y') }} {{ AppSetting('title'); }}. {{ __('por CORE') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

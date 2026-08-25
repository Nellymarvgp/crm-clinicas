@extends('layouts.master-landing')

@section('title', 'Cita Agendada con Éxito')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="mdi mdi-check-circle-outline text-success" style="font-size: 80px;"></i>
                </div>
                <h2 class="mb-3">¡Tu cita ha sido agendada con éxito!</h2>
                <p class="mb-4">Hemos enviado un correo electrónico con los detalles de tu cita. Por favor revisa tu bandeja de entrada.</p>
                <div class="alert alert-info">
                    <p class="mb-0">Si no has recibido el correo electrónico, por favor revisa tu carpeta de spam o ponte en contacto con nosotros.</p>
                </div>
                <div class="mt-4">
                    <a href="{{ route('public.appointment.create') }}" class="btn btn-outline-primary mr-2">Agendar otra cita</a>
                    <a href="{{ url('/') }}" class="btn btn-primary">Volver al inicio</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

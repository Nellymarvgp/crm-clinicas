@extends('layouts.master-landing')

@section('title', 'Solicitar Llamada')

@section('css')
<style>
    .call-form-container {
        max-width: 550px;
        margin: 0 auto;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        background-color: #fff;
    }
    
    .call-form-heading {
        color: #4FB1B1;
        text-align: center;
        margin-bottom: 30px;
    }
    
    .btn-success {
        background-color: #4FB1B1 !important;
        border-color: #4FB1B1 !important;
    }
    
    .btn-success:hover {
        background-color: #429a9a !important;
        border-color: #429a9a !important;
    }
    
    .form-control:focus {
        border-color: #4FB1B1;
        box-shadow: 0 0 0 0.2rem rgba(79, 177, 177, 0.25);
    }
    
    .call-form-banner {
        text-align: center;
        margin-bottom: 20px;
    }
    
    .call-form-banner i {
        font-size: 64px;
        color: #4FB1B1;
    }
    
    .call-form-wrapper {
        padding-top: 70px;
        padding-bottom: 70px;
    }
    
    .required::after {
        content: " *";
        color: red;
    }
</style>
@endsection

@section('content')
<div class="call-form-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="call-form-container">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="call-form-banner">
                        <i class="mdi mdi-phone-in-talk-outline"></i>
                    </div>
                    
                    <h2 class="call-form-heading">Solicitar Llamada</h2>
                    <p class="text-center mb-4">Complete el formulario y un agente se comunicará con usted a la brevedad</p>
                    
                    <form method="POST" action="{{ route('request-call.process') }}" id="call-form">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="required">Nombre completo</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="phone" class="required">Teléfono</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Ej. +1234567890" required>
                            @error('phone')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        @if(count($agents) > 1)
                        <div class="form-group">
                            <label for="agent_id" class="required">Departamento</label>
                            <select class="form-control @error('agent_id') is-invalid @enderror" id="agent_id" name="agent_id" required>
                                <option value="">Seleccione un departamento</option>
                                @foreach($agents as $agent)
                                    <option value="{{ $agent->id }}" {{ old('agent_id') == $agent->id ? 'selected' : '' }}>{{ $agent->agent_name }}</option>
                                @endforeach
                            </select>
                            @error('agent_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        @else
                            <input type="hidden" name="agent_id" value="{{ $agents->first()->id ?? '' }}">
                        @endif
                        
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-success btn-block">Solicitar Llamada</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        // Validación simple del número de teléfono
        $('#call-form').on('submit', function(e) {
            const phoneInput = $('#phone');
            const phoneValue = phoneInput.val().trim();
            
            // Validación básica: al menos 10 caracteres
            if (phoneValue.length < 10) {
                e.preventDefault();
                phoneInput.addClass('is-invalid');
                if (!phoneInput.next('.invalid-feedback').length) {
                    phoneInput.after('<div class="invalid-feedback">El número de teléfono debe tener al menos 10 dígitos</div>');
                }
                return false;
            }
            
            return true;
        });
        
        // Limpiar validación al cambiar el valor
        $('#phone').on('input', function() {
            $(this).removeClass('is-invalid');
        });
    });
</script>
@endsection

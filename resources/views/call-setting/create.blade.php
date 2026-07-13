@extends('layouts.master-layouts')

@section('title') Crear Configuración de Llamada @endsection

@section('css')
    <style>
        .btn-success {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
        }
        .btn-success:hover, .btn-success:focus, .btn-success:active {
            background-color: #218838 !important;
            border-color: #1e7e34 !important;
        }
        .custom-control-input:checked ~ .custom-control-label::before {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
        }
        .add-param-btn {
            color: #28a745;
            border-color: #28a745;
        }
        .add-param-btn:hover {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
        }
        .remove-param-btn {
            color: #dc3545;
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('title') Crear Configuración de Llamada @endslot
        @slot('li_1') Admin @endslot
        @slot('li_2') Configuraciones @endslot
        @slot('li_3') Llamadas @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('setting-call.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="agent_name">Nombre del Agente <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('agent_name') is-invalid @enderror" id="agent_name" name="agent_name" value="{{ old('agent_name') }}" required>
                                    @error('agent_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="agent_id">ID del Agente <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('agent_id') is-invalid @enderror" id="agent_id" name="agent_id" value="{{ old('agent_id') }}" required>
                                    @error('agent_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="call_url">URL de Llamada <span class="text-danger">*</span></label>
                            <input type="url" class="form-control @error('call_url') is-invalid @enderror" id="call_url" name="call_url" value="{{ old('call_url') }}" placeholder="https://ejemplo.com/api/call" required>
                            @error('call_url')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">URL a la que se enviarán las solicitudes de llamada</small>
                        </div>

                        <div class="form-group">
                            <label>Parámetros (clave-valor)</label>
                            <div id="parameters-container">
                                @if(old('parameters'))
                                    @foreach(old('parameters') as $index => $param)
                                        <div class="row param-row mb-2">
                                            <div class="col-md-5">
                                                <input type="text" class="form-control @error('parameters.'.$index.'.key') is-invalid @enderror" name="parameters[{{ $index }}][key]" placeholder="Clave" value="{{ $param['key'] ?? '' }}">
                                                @error('parameters.'.$index.'.key')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-5">
                                                <input type="text" class="form-control @error('parameters.'.$index.'.value') is-invalid @enderror" name="parameters[{{ $index }}][value]" placeholder="Valor" value="{{ $param['value'] ?? '' }}">
                                                @error('parameters.'.$index.'.value')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-2">
                                                <i class="mdi mdi-close-circle remove-param-btn align-middle" style="font-size: 24px;"></i>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <!-- Fila inicial vacía -->
                                    <div class="row param-row mb-2">
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="parameters[0][key]" placeholder="Clave">
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="parameters[0][value]" placeholder="Valor">
                                        </div>
                                        <div class="col-md-2">
                                            <i class="mdi mdi-close-circle remove-param-btn align-middle" style="font-size: 24px;"></i>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <button type="button" id="add-param-btn" class="btn btn-outline-success btn-sm add-param-btn mt-2">
                                <i class="mdi mdi-plus"></i> Agregar Parámetro
                            </button>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" checked>
                                <label class="custom-control-label" for="is_active">Activo</label>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-success mr-2">Guardar</button>
                            <a href="{{ route('setting-call.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Agregar parámetro
            $('#add-param-btn').on('click', function() {
                const index = $('.param-row').length;
                const newRow = `
                    <div class="row param-row mb-2">
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="parameters[${index}][key]" placeholder="Clave">
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="parameters[${index}][value]" placeholder="Valor">
                        </div>
                        <div class="col-md-2">
                            <i class="mdi mdi-close-circle remove-param-btn align-middle" style="font-size: 24px;"></i>
                        </div>
                    </div>
                `;
                $('#parameters-container').append(newRow);
            });
            
            // Eliminar parámetro
            $(document).on('click', '.remove-param-btn', function() {
                if ($('.param-row').length > 1) {
                    $(this).closest('.param-row').remove();
                } else {
                    // Si es la última fila, solo limpiar los campos
                    $(this).closest('.param-row').find('input').val('');
                }
            });
        });
    </script>
@endsection

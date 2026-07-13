@extends('layouts.master-layouts')

@section('title') Configuración de Llamadas @endsection

@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}">
    <style>
        .btn-success {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
        }
        .btn-success:hover, .btn-success:focus, .btn-success:active {
            background-color: #218838 !important;
            border-color: #1e7e34 !important;
        }
        .page-item.active .page-link {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
        }
    </style>
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('title') Configuración de Llamadas @endslot
        @slot('li_1') Admin @endslot
        @slot('li_2') Configuraciones @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <div class="search-box mr-2 mb-2 d-inline-block">
                                <div class="position-relative">
                                    <input type="text" class="form-control" placeholder="Buscar..." id="search-box">
                                    <i class="bx bx-search-alt search-icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-right">
                                <a href="{{ route('setting-call.create') }}">
                                    <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                                        <i class="bx bx-plus font-size-16 align-middle mr-2"></i> Nueva Configuración
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>

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

                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap" id="datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre del Agente</th>
                                    <th>ID del Agente</th>
                                    <th>URL de Llamada</th>
                                    <th>Parámetros</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($callSettings as $callSetting)
                                    <tr>
                                        <td>{{ $callSetting->id }}</td>
                                        <td>{{ $callSetting->agent_name }}</td>
                                        <td>{{ $callSetting->agent_id }}</td>
                                        <td>
                                            <div class="text-truncate" style="max-width: 200px;" title="{{ $callSetting->call_url }}">
                                                {{ $callSetting->call_url }}
                                            </div>
                                        </td>
                                        <td>
                                            @if(!empty($callSetting->parameters))
                                                <button type="button" class="btn btn-sm btn-info view-params" data-toggle="modal" data-target="#paramsModal" data-params="{{ json_encode($callSetting->parameters) }}">
                                                    Ver ({{ count($callSetting->parameters) }})
                                                </button>
                                            @else
                                                <span class="badge badge-secondary">Sin parámetros</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($callSetting->is_active)
                                                <span class="badge badge-success">Activo</span>
                                            @else
                                                <span class="badge badge-danger">Inactivo</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('setting-call.edit', $callSetting->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger delete-setting" data-id="{{ $callSetting->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para ver parámetros -->
    <div class="modal fade" id="paramsModal" tabindex="-1" role="dialog" aria-labelledby="paramsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paramsModalLabel">Parámetros de la Configuración</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Clave</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody id="params-table-body">
                                <!-- Se llena con JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Required datatable js -->
    <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Inicializar DataTable
            var table = $('#datatable').DataTable({
                language: {
                    url: "{{ URL::asset('assets/libs/datatables/Spanish.json') }}"
                }
            });
            
            // Búsqueda en DataTable
            $('#search-box').on('keyup', function() {
                table.search($(this).val()).draw();
            });
            
            // Mostrar parámetros en modal
            $('.view-params').on('click', function() {
                const params = $(this).data('params');
                const tableBody = $('#params-table-body');
                tableBody.empty();
                
                if (params) {
                    Object.entries(params).forEach(([key, value]) => {
                        tableBody.append(`
                            <tr>
                                <td>${key}</td>
                                <td>${value}</td>
                            </tr>
                        `);
                    });
                } else {
                    tableBody.append('<tr><td colspan="2" class="text-center">No hay parámetros configurados</td></tr>');
                }
            });
            
            // Eliminar configuración
            $(document).on('click', '.delete-setting', function() {
                var id = $(this).data('id');
                if (confirm('¿Estás seguro de que deseas eliminar esta configuración?')) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ url('setting-call') }}/" + id,
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id,
                        },
                        success: function(data) {
                            // Actualizar la tabla después de eliminar
                            table.ajax.reload();
                        }
                    });
                }
            });
        });
    </script>
@endsection

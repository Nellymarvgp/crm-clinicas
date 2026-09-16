@extends('layouts.master-layouts')
@section('title')
    {{ __('Lista de Pacientes') }}
@endsection
@section('css')
    <!-- Datatables -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet" />
    <style type="text/css">
        #patientList_length label {
            display: inline-flex;
            align-items: center;
            gap: 04px;
        }
    </style>
@endsection
@section('content')
    <!-- start page title -->
    @component('components.breadcrumb')
        @slot('title')
            Lista de Pacientes
        @endslot
        @slot('li_1')
            Panel
        @endslot
        @slot('li_2')
            Pacientes
        @endslot
    @endcomponent
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 ms-auto">
                            <label for="patientCedulaFilter" class="form-label mb-1">{{ __('Buscar') }}</label>
                            <input type="text" id="patientCedulaFilter" class="form-control" placeholder="Buscar">
                        </div>
                    </div>
                    <a href=" {{ route('patient.create') }} ">
                        <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                            <i class="bx bx-plus font-size-16 align-middle me-2"></i> {{ __('Nuevo Paciente') }}
                        </button>
                    </a>
                    <table id="patientList" class="table table-bordered dt-responsive nowrap display"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>{{ __('Nro.') }}</th>
                                <th>{{ __('Nombre') }}</th>
                                <th>{{ __('Cédula') }}</th>
                                <th>{{ __('Número de Contacto') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Opciones') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection
@section('script')
    <!-- Plugins js -->
    <script src="{{ URL::asset('build/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/pdfmake/build/vfs_fonts.js') }}"></script>
     <!-- Datatables -->
     <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
     <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
     <script type="text/javascript" charset="utf8"
         src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
     <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js">
     </script>
     <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js">
     </script>

    <!-- Init js-->
    <script src="{{ URL::asset('build/js/pages/notification.init.js') }}"></script>
    <script>
        // Load Datatable
        $(document).ready(function() {
            var patientTable = $('#patientList').DataTable({
                processing: true,
                serverSide: true,
                dom: 'Brtip',
                buttons: [
                    'copy', 'excel', 'pdf'
                ],
                ajax: "{{ route('patient.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                        sortable: false,
                        visible: true,
                        searchable: true
                    },
                    {
                        data: 'cedula',
                        name: 'cedula',
                        searchable: true,
                        orderable: false
                    },
                    {
                        data: 'mobile',
                        name: 'mobile',
                        searchable: true
                    },
                    {
                        data: 'email',
                        name: 'email',
                        searchable: true
                    },
                    {
                        data: 'option',
                        name: 'option',
                        orderable: false,
                        searchable: false
                    },
                ],
                pagingType: 'full_numbers',
                initComplete: function() {
                    var api = this.api();
                    $('#patientCedulaFilter').on('keyup change', function() {
                        api.column(2).search(this.value).draw();
                    });
                },
                "drawCallback": function() {
                    $('.dataTables_paginate > .pagination').addClass('justify-content-end');
                    $('.dataTables_filter').addClass('d-flex justify-content-end');
                }
            });

            $('#patientCedulaFilter').on('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                }
            });
        });

        //delete patient
        $(document).on('click', '#delete-patient', function() {
            var id = $(this).data('id');
            if (confirm('¿Seguro que desea eliminar a este paciente?')) {
                $.ajax({
                    type: "DELETE",
                    url: 'patient/' + id,
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                    },
                    beforeSend: function() {
                        $('#pageloader').show()
                    },
                    success: function(response) {
                        toastr.success(response.message, 'Success Alert', {
                            timeOut: 2000
                        });
                        location.reload();
                    },
                    error: function(response) {
                        toastr.error(response.responseJSON.message, {
                            timeOut: 20000
                        });
                    },
                    complete: function() {
                        $('#pageloader').hide();
                    }
                });
            }
        });
    </script>
@endsection

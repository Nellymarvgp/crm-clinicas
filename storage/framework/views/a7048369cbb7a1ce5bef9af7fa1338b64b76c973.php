<?php $__env->startSection('title'); ?>
    <?php echo e(__('Lista de Pacientes')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <!-- start page title -->
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('title'); ?>
            Lista de Pacientes
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('li_1'); ?>
            Panel
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('li_2'); ?>
            Pacientes
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 ms-auto">
                            <label for="patientSearchFilter" class="form-label mb-1"><?php echo e(__('Buscar por nombre, apellido o cédula')); ?></label>
                            <input type="text" id="patientSearchFilter" class="form-control" placeholder="Buscar">
                        </div>
                    </div>
                    <a href=" <?php echo e(route('patient.create')); ?> ">
                        <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                            <i class="bx bx-plus font-size-16 align-middle me-2"></i> <?php echo e(__('Nuevo Paciente')); ?>

                        </button>
                    </a>
                    <table id="patientList" class="table table-bordered dt-responsive nowrap display"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th><?php echo e(__('Nro.')); ?></th>
                                <th><?php echo e(__('Nombre')); ?></th>
                                <th><?php echo e(__('Cédula')); ?></th>
                                <th><?php echo e(__('Número de Contacto')); ?></th>
                                <th><?php echo e(__('Email')); ?></th>
                                <th><?php echo e(__('Opciones')); ?></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <!-- Plugins js -->
    <script src="<?php echo e(URL::asset('build/libs/jszip/jszip.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/pdfmake/build/pdfmake.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/pdfmake/build/vfs_fonts.js')); ?>"></script>
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
    <script src="<?php echo e(URL::asset('build/js/pages/notification.init.js')); ?>"></script>
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
                ajax: "<?php echo e(route('patient.index')); ?>",
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
                    $('#patientSearchFilter').on('keyup change', function() {
                        api.search(this.value).draw();
                    });
                },
                "drawCallback": function() {
                    $('.dataTables_paginate > .pagination').addClass('justify-content-end');
                    $('.dataTables_filter').addClass('d-flex justify-content-end');
                }
            });

            $('#patientSearchFilter').on('keydown', function(e) {
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
                        _token: '<?php echo e(csrf_token()); ?>',
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views/patient/patients.blade.php ENDPATH**/ ?>
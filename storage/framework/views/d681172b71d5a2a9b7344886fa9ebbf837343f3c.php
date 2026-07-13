<?php $__env->startSection('title'); ?> Configuración de Llamadas <?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(URL::asset('assets/libs/datatables/datatables.min.css')); ?>">
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('title'); ?> Configuración de Llamadas <?php $__env->endSlot(); ?>
        <?php $__env->slot('li_1'); ?> Admin <?php $__env->endSlot(); ?>
        <?php $__env->slot('li_2'); ?> Configuraciones <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

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
                                <a href="<?php echo e(route('setting-call.create')); ?>">
                                    <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                                        <i class="bx bx-plus font-size-16 align-middle mr-2"></i> Nueva Configuración
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>

                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo e(session('success')); ?>

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo e(session('error')); ?>

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

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
                                <?php $__currentLoopData = $callSettings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $callSetting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($callSetting->id); ?></td>
                                        <td><?php echo e($callSetting->agent_name); ?></td>
                                        <td><?php echo e($callSetting->agent_id); ?></td>
                                        <td>
                                            <div class="text-truncate" style="max-width: 200px;" title="<?php echo e($callSetting->call_url); ?>">
                                                <?php echo e($callSetting->call_url); ?>

                                            </div>
                                        </td>
                                        <td>
                                            <?php if(!empty($callSetting->parameters)): ?>
                                                <button type="button" class="btn btn-sm btn-info view-params" data-toggle="modal" data-target="#paramsModal" data-params="<?php echo e(json_encode($callSetting->parameters)); ?>">
                                                    Ver (<?php echo e(count($callSetting->parameters)); ?>)
                                                </button>
                                            <?php else: ?>
                                                <span class="badge badge-secondary">Sin parámetros</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($callSetting->is_active): ?>
                                                <span class="badge badge-success">Activo</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger">Inactivo</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('setting-call.edit', $callSetting->id)); ?>" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger delete-setting" data-id="<?php echo e($callSetting->id); ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <!-- Required datatable js -->
    <script src="<?php echo e(URL::asset('assets/libs/datatables/datatables.min.js')); ?>"></script>
    <script>
        $(document).ready(function() {
            // Inicializar DataTable
            var table = $('#datatable').DataTable({
                language: {
                    url: "<?php echo e(URL::asset('assets/libs/datatables/Spanish.json')); ?>"
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
                        url: "<?php echo e(url('setting-call')); ?>/" + id,
                        data: {
                            _token: '<?php echo e(csrf_token()); ?>',
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views/call-setting/index.blade.php ENDPATH**/ ?>
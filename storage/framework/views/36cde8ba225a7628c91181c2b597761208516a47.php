<?php $__env->startSection('title', 'Cita Agendada con Éxito'); ?>

<?php $__env->startSection('content'); ?>
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
                    <a href="<?php echo e(route('public.appointment.create')); ?>" class="btn btn-outline-primary mr-2">Agendar otra cita</a>
                    <a href="<?php echo e(url('/')); ?>" class="btn btn-primary">Volver al inicio</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views\public\appointments\success.blade.php ENDPATH**/ ?>
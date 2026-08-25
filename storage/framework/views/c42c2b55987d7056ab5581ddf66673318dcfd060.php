<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema de Citas para Clínicas">
    <meta name="author" content="CORE">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    
    <title>CRM Clínicas - <?php echo $__env->yieldContent('title', 'Bienvenido'); ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" />

    <!-- Icons CSS -->
    <link href="<?php echo e(asset('assets/css/icons.min.css')); ?>" rel="stylesheet" type="text/css" />
    
    <!-- App CSS -->
    <link href="<?php echo e(asset('assets/css/app.min.css')); ?>" rel="stylesheet" type="text/css" id="app-style" />
    <link href="<?php echo e(asset('assets/css/custom-colors.css')); ?>" rel="stylesheet" type="text/css" />

    <!-- Custom styles -->
    <link href="<?php echo e(asset('assets/css/custom.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/css/hamburger-menu.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/css/override.css')); ?>" rel="stylesheet" type="text/css" />

    <!-- Fullcalendar CSS -->
    <link href="<?php echo e(asset('assets/libs/fullcalendar/main.min.css')); ?>" rel="stylesheet" type="text/css" />

    <!-- iCalendar library -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        body {
            font-family: 'Inter', 'Roboto', sans-serif;
            background-color: #F5F5F5;
            color: #333333;
        }
        .header-public {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
        }
        .brand-logo {
            max-height: 50px;
        }
        .btn-primary {
            background-color: #d1cba4 !important;
            border-color: #d1cba4 !important;
            color: #7c7c7b !important;
        }
        .btn-primary:hover {
            background-color: #c6bf92 !important;
            border-color: #c6bf92 !important;
            color: #666665 !important;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }
        .card-header {
            background-color: #ffffff;
            border-bottom: 1px solid #e5e5e5;
            font-weight: 600;
        }
        .footer-public {
            background-color: #333333;
            color: #ffffff;
            padding: 30px 0;
            margin-top: 50px;
        }
        .footer-public a {
            color: #ffffff;
        }
        .required:after {
            content: " *";
            color: red;
        }
        .flatpickr-day.selected, .flatpickr-day.startRange, .flatpickr-day.endRange, .flatpickr-day.selected.inRange, .flatpickr-day.startRange.inRange, .flatpickr-day.endRange.inRange, .flatpickr-day.selected:focus, .flatpickr-day.startRange:focus, .flatpickr-day.endRange:focus, .flatpickr-day.selected:hover, .flatpickr-day.startRange:hover, .flatpickr-day.endRange:hover, .flatpickr-day.selected.prevMonthDay, .flatpickr-day.startRange.prevMonthDay, .flatpickr-day.endRange.prevMonthDay, .flatpickr-day.selected.nextMonthDay, .flatpickr-day.startRange.nextMonthDay, .flatpickr-day.endRange.nextMonthDay {
            background: #d1cba4;
            border-color: #d1cba4;
            color: #7c7c7b;
        }
    </style>
    <?php echo $__env->yieldContent('styles'); ?>
</head>

<body>
    <header class="header-public">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <a href="<?php echo e(url('/')); ?>">
                        <img src="<?php echo e(asset('assets/images/logo-dark.png')); ?>" alt="CRM Clínicas" class="brand-logo">
                    </a>
                </div>
                <div class="col-md-8 text-right">
                    <nav class="d-none d-md-block">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item"><a href="<?php echo e(url('/')); ?>" class="text-dark mr-3">Inicio</a></li>
                            <li class="list-inline-item"><a href="<?php echo e(route('doctors.find')); ?>" class="text-dark mr-3">Encontrar Doctor</a></li>
                            <li class="list-inline-item"><a href="<?php echo e(route('public.appointment.create')); ?>" class="text-dark mr-3">Agendar Cita</a></li>
                            <li class="list-inline-item"><a href="<?php echo e(url('login')); ?>" class="btn btn-primary">Iniciar Sesión</a></li>
                        </ul>
                    </nav>
                    <div class="d-md-none">
                        <div class="hamburger-menu">
                            <div class="hamburger-icon" id="hamburger-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                            <div class="menu-overlay" id="menu-overlay"></div>
                            <div class="mobile-menu" id="mobile-menu">
                                <ul>
                                    <li><a href="<?php echo e(url('/')); ?>">Inicio</a></li>
                                    <li><a href="<?php echo e(route('doctors.find')); ?>">Encontrar Doctor</a></li>
                                    <li><a href="<?php echo e(route('public.appointment.create')); ?>">Agendar Cita</a></li>
                                    <li><a href="<?php echo e(url('login')); ?>">Iniciar Sesión</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="py-5">
        <div class="container">
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

            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </main>

    <footer class="footer-public">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>CRM Clínicas</h5>
                    <p>Sistema de gestión para clínicas y centros médicos.</p>
                </div>
                <div class="col-md-4">
                    <h5>Enlaces Rápidos</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo e(url('/')); ?>">Inicio</a></li>
                        <li><a href="<?php echo e(route('doctors.find')); ?>">Encontrar Doctor</a></li>
                        <li><a href="<?php echo e(route('public.appointment.create')); ?>">Agendar Cita</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contacto</h5>
                    <ul class="list-unstyled">
                        <li><i class="mdi mdi-map-marker-outline mr-2"></i> Dirección de la Clínica</li>
                        <li><i class="mdi mdi-phone mr-2"></i> +1 234 567 890</li>
                        <li><i class="mdi mdi-email-outline mr-2"></i> info@crmclinicas.com</li>
                    </ul>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12 text-center">
                    <p class="mb-0">&copy; <?php echo e(date('Y')); ?> CRM Clínicas. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript Libraries -->
    <script src="<?php echo e(asset('assets/js/vendor.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/app.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/hamburger-menu.js')); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views\layouts\public.blade.php ENDPATH**/ ?>
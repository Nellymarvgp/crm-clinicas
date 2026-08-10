<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo $__env->yieldContent('title'); ?> | CORE - Centro Odontológico de Rehabilitación Estética</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="CORE es un centro odontológico orientado a rehabilitación estética, control de pacientes y especialidades dentales.">
    <meta name="keywords" content="CORE, odontología, rehabilitación estética, clínica dental, citas odontológicas, Venezuela">
    <meta name="author" content="CORE">

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo e(URL::asset('build/images/') . '/' . AppSetting('favicon')); ?>">
    
    <!-- Bootstrap CSS -->
    <link href="<?php echo e(URL::asset('build/libs/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(URL::asset('assets/css/custom-colors.css')); ?>" rel="stylesheet" type="text/css" />
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Landing page specific styles -->
    <style>
        /* Navbar styles */
        .navbar-custom {
            padding: 15px 0;
            transition: all 0.3s ease;
        }
        .navbar-custom.sticky {
            background-color: #fff !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .navbar-custom .navbar-nav .nav-link {
            color: var(--text-color);
            font-weight: 500;
            padding: 10px 20px;
        }
        .navbar-custom .navbar-nav .nav-link:hover,
        .navbar-custom .navbar-nav .nav-link.active {
            color: var(--secondary-color);
        }
        /* Footer styles */
        .footer {
            background-color: var(--primary-color);
            padding: 60px 0 30px;
            color: var(--text-color);
        }
        .footer h4 {
            color: var(--text-color);
            font-size: 18px;
            margin-bottom: 20px;
        }
        .footer ul {
            list-style: none;
            padding: 0;
        }
        .footer ul li {
            margin-bottom: 10px;
        }
        .footer ul li a {
            color: var(--text-color);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .footer ul li a:hover {
            color: var(--secondary-color);
            padding-left: 5px;
        }
        .footer .social-links a {
            display: inline-block;
            width: 35px;
            height: 35px;
            background: var(--secondary-color);
            color: white;
            text-align: center;
            line-height: 35px;
            border-radius: 50%;
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        .footer .social-links a:hover {
            background: var(--text-color);
            transform: translateY(-3px);
        }
        .footer-bottom {
            padding-top: 30px;
            margin-top: 30px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        /* Global theme colors */
        :root {
            --primary-color: #d1cba4;
            --secondary-color: #7c7c7b;
            --text-color: #7c7c7b;
            --bg-light: #ffffff87;
        }
    </style>
    <?php echo $__env->yieldContent('css'); ?>
</head>

<body>
    <!-- Navbar -->
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top navbar-custom sticky sticky-light"
            id="navbar" style="background-color: #fff !important;">
            <div class="container">
                <a class="navbar-brand logo" href="/">
                    <span class="d-flex align-items-center gap-2 fw-bold" style="color: #7c7c7b;">
                        <i class="fas fa-tooth"></i>
                        CORE
                    </span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/#home">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#services">Servicios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#commitment">Compromiso</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#team">Equipo</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('doctors.find')); ?>">Doctores</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#contact">Contacto</a>
                        </li>
                    </ul>
                    <div class="d-flex">
                        <a href="<?php echo e(url('/login')); ?>" class="btn btn-sm" style="background-color: var(--secondary-color); color: white;">
                            <i class="fas fa-user-lock me-1"></i> Panel
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <?php echo $__env->yieldContent('content'); ?>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                    <h4>Sobre Nosotros</h4>
                    <p>CORE es un centro odontológico especializado en rehabilitación estética, prevención y atención integral de la sonrisa.</p>
                    <div class="social-links mt-3">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                    <h4>Enlaces Rápidos</h4>
                    <ul>
                        <li><a href="/#home">Inicio</a></li>
                        <li><a href="/#services">Servicios</a></li>
                        <li><a href="/#team">Nuestro Equipo</a></li>
                        <li><a href="/#contact">Contacto</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h4>Información de Contacto</h4>
                    <ul>
                        <li><i class="fas fa-map-marker-alt me-2"></i> Av. Principal #123, Ciudad</li>
                        <li><i class="fas fa-phone me-2"></i> (123) 456-7890</li>
                        <li><i class="fas fa-envelope me-2"></i> info@centromedicobosque.com</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom text-center">
                <p class="mb-0">&copy; <?php echo e(date('Y')); ?> CORE. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- JAVASCRIPT -->
    <script src="<?php echo e(URL::asset('build/libs/jquery/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <!-- Navbar Scroll Effect -->
    <script>
        $(window).scroll(function() {
            if ($(window).scrollTop() > 0) {
                $('.navbar-custom').addClass('sticky');
            } else {
                $('.navbar-custom').removeClass('sticky');
            }
        });

        // Active menu item based on URL
        $(document).ready(function() {
            let currentUrl = window.location.pathname;
            $('.navbar-nav .nav-link').each(function() {
                if ($(this).attr('href') === currentUrl) {
                    $(this).addClass('active');
                }
            });
        });
    </script>

    <?php echo $__env->yieldContent('script'); ?>
</body>
</html>
<?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views/layouts/master-landing.blade.php ENDPATH**/ ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>CORE | Centro Odontológico de Rehabilitación Estética</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="CORE es un centro odontológico orientado a rehabilitación estética, control de pacientes, citas y especialidades dentales.">
    <meta name="keywords" content="CORE, odontología, rehabilitación estética, clínica dental, citas odontológicas, Venezuela">
    <meta name="author" content="CORE">

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo e(URL::asset('build/images/') . '/' . AppSetting('favicon')); ?>">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    <!-- Slick Carousel CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    
    <?php echo $__env->make('layouts.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <link href="<?php echo e(URL::asset('build/css/app.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(URL::asset('build/css/landing.css')); ?>" rel="stylesheet" type="text/css" />
</head>

<body>

    <div class="landing-page">
        <!-- header nav bar start  -->
        <header>
            <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top navbar-custom sticky sticky-light"
                id="navbar">
                <div class="container">
                    <a class="navbar-brand logo d-flex align-items-center" href="#home" aria-label="CORE">
                        <img src="<?php echo e(URL::asset('build/images/logo.jpg')); ?>" alt="Logo CORE" class="core-logo">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav mx-auto">
                            <?php if($data['Home'] == 0): ?>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="#home">Inicio</a>
                                </li>
                            <?php endif; ?>
                            <?php if($data['Services'] == 0): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="#services">Especialidades</a>
                                </li>
                            <?php endif; ?>
                            <li class="nav-item">
                                <a class="nav-link" href="#brand">Nosotros</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#commitment">Compromiso</a>
                            </li>
                            <?php if($data['Team'] == 0): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="#team">Equipo</a>
                                </li>
                            <?php endif; ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('doctors.find')); ?>">Odontólogos</a>
                            </li>
                            <?php if($data['Contact'] == 0): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="#contact">Contacto</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                        <div class="d-flex">
                            <?php if(Sentinel::check()): ?>
                                <a href="<?php echo e(url('dashboard')); ?>" class="btn btn-sm">
                                    <i class="fas fa-user-lock me-1"></i> Panel
                                </a>
                            <?php else: ?>
                                <a href="<?php echo e(url('login')); ?>" class="btn btn-sm">
                                    <i class="fas fa-user-lock me-1"></i> Panel
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <!-- header nav bar end  -->


        <!-- home-section start -->
        <?php if($data['Home'] == 0): ?>
            <section class="PrimerBloque" id="home">
                <div class="containers">
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <div class="blockLeft">
                                <div class="content">
                                    <h1>CORE</h1>
                                    <p>Centro Odontológico y Rehabilitación Estética. Transformamos la experiencia dental con atención integral, tecnología moderna y un trato humano que devuelve confianza a cada sonrisa.</p>
                                    <div class="hero-btn mt-4">
                                        <a href="<?php echo e(url('login')); ?>" class="btn btn-primary">Agendar cita</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="blockRight">
                                <div class="content">
                                    <img src="<?php echo e(URL::asset('build/images/fondo-bg.jpg')); ?>" alt="" class="image-bg">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- home-section end  -->
        <?php endif; ?>

        <?php if($data['Services'] == 0): ?>
            <!-- services-section start  -->
            <section class="servicios-section" id="services">
                <div class="container">
                    <h2>Nuestras especialidades</h2>
                    <div class="row">
                        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-lg-4 col-md-6">
                                <div class="servicio-card">
                                    <div class="servicio-icon">
                                        <i class="fas fa-tooth"></i>
                                    </div>
                                    <h3><?php echo e($department->name); ?></h3>
                                    <p><?php echo e($department->description); ?></p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </section>
            <!-- services-section end  -->
        <?php endif; ?>

        <!-- commitment-section start  -->
            <section class="CuartoBloque" id="commitment" style="background: url(<?php echo e(URL::asset('build/images/fondo-od.jpg')); ?>) no-repeat center center/cover;">
                <div class="containers">
                    <div class="content">
                        <div class="row">
                            <div class="col-md-12">
                                <img src="<?php echo e(URL::asset('build/images/servicio1.png')); ?>" alt="">
                                <h2>Tu sonrisa, nuestra prioridad</h2>
                                <p>En Centro Odontológico CORE cada paciente recibe atención personalizada, respaldada por especialistas altamente capacitados y tecnología de vanguardia, en un entorno seguro, cálido y profesional.</p>
                                <div class="hero-btn mt-4">
                                    <a href="<?php echo e(url('login')); ?>" class="btn btn-primary">Conocer más</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- commitment-section end  -->

            <section class="brand-section" id="brand">
                <div class="container">
                    <div class="brand-header">
                        <h2>Identidad CORE</h2>
                        <p>Somos una marca moderna, profesional, cercana, elegante, confiable y humana, con un enfoque detallista e innovador en cada etapa del tratamiento odontológico.</p>
                    </div>

                    <div class="brand-grid">
                        <article class="brand-card">
                            <h3>Misión</h3>
                            <p>Brindar atención odontológica integral con altos estándares de calidad, combinando tecnología de vanguardia, especialistas en distintas áreas y un enfoque centrado en cada paciente para mejorar su salud oral, funcionalidad y estética.</p>
                        </article>
                        <article class="brand-card">
                            <h3>Visión</h3>
                            <p>Ser el centro odontológico de referencia en Venezuela por nuestra excelencia profesional, innovación tecnológica y calidad humana, estableciendo nuevos estándares de atención y experiencia para el paciente.</p>
                        </article>
                        <article class="brand-card">
                            <h3>Propósito</h3>
                            <p>Transformar la manera en que las personas viven la atención odontológica, uniendo salud, estética, tecnología y calidez humana para devolver seguridad y bienestar a cada sonrisa.</p>
                        </article>
                        <article class="brand-card">
                            <h3>Esencia de marca</h3>
                            <p><strong>Confianza.</strong> Es el vínculo que construimos con cada paciente a través de la honestidad, la excelencia clínica, la innovación y un trato genuinamente humano.</p>
                        </article>
                    </div>



                    <div class="values-grid">
                        <article class="value-card">
                            <h4>Excelencia</h4>
                            <p>Máxima calidad en cada diagnóstico, tratamiento y detalle de atención.</p>
                        </article>
                        <article class="value-card">
                            <h4>Innovación</h4>
                            <p>Tecnología y técnicas de vanguardia para tratamientos modernos, seguros y eficientes.</p>
                        </article>
                        <article class="value-card">
                            <h4>Compromiso</h4>
                            <p>Dedicación para lograr resultados funcionales, estéticos y duraderos.</p>
                        </article>
                        <article class="value-card">
                            <h4>Confianza</h4>
                            <p>Relaciones sólidas con comunicación clara y cumplimiento de lo que prometemos.</p>
                        </article>
                        <article class="value-card">
                            <h4>Calidez humana</h4>
                            <p>Una experiencia donde cada paciente se siente escuchado, cómodo y valorado.</p>
                        </article>
                    </div>

                
                </div>
            </section>
            
        <?php if($data['Team'] == 0): ?>
            <!-- doctors-section start  -->
            <section class="TercerBloque" id="team">
                <div class="content">
                    <h2>Conoce a nuestros odontólogos</h2>
                    <div class="doctor-carousel">
                        <!-- Slider main container -->
                        <div class="swiper">
                            <!-- Additional required wrapper -->
                            <div class="swiper-wrapper">
                                <!-- Slides -->
                                <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="swiper-slide">
                                        <div class="box-team">
                                            <?php if($doctor->user && $doctor->user->profile_photo): ?>
                                                <img src="<?php echo e(URL::asset('storage/images/users/'.$doctor->user->profile_photo)); ?>" alt="Doctor Photo">
                                            <?php else: ?>
                                                <img src="<?php echo e(URL::asset('build/images/users/avatar-1.jpg')); ?>" alt="Default Photo">
                                            <?php endif; ?>
                                            <h4><?php echo e($doctor->user ? 'Dr. '.$doctor->user->first_name.' '.$doctor->user->last_name : 'Odontólogo'); ?></h4>
                                            <span><?php echo e($doctor->department ? $doctor->department->name : 'Especialidad'); ?></span>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <!-- Add Navigation -->
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                            <!-- Add Pagination -->
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                    <div class="view-all-btn">
                        <a href="<?php echo e(route('doctors.find')); ?>" class="btn">Ver todos los odontólogos</a>
                    </div>
                </div>
            </section>
            <!-- doctors-section end  -->
        <?php endif; ?>

        

        <?php if($data['Contact'] == 0): ?>
            <!-- cta-section start  -->
            <section class="CuartoBloque" id="contact" style="background: url(<?php echo e(URL::asset('build/images/fondo-consulta.jpg')); ?>) no-repeat center center/cover;">
                <div class="containers">
                    <div class="content">
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <i class="fas fa-tooth fa-3x text-brand mb-3"></i>
                                <h2>CORE <br>Centro Odontológico</h2>
                                <div class="hero-btn mt-4">
                                    <a href="<?php echo e(url('login')); ?>" class="btn btn-primary">Agenda una consulta</a>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <p>COMUNÍCATE CON NOSOTROS</p>
                                <div>
                                    <b>Dirección</b>
                                    <p>Venezuela</p>
                                </div>
                                <div>
                                    <b>Correo corporativo</b>
                                    <p><a href="mailto:info@corecentrove.com">info@corecentrove.com</a></p>
                                </div>
                                <div>
                                    <b>Correo público</b>
                                    <p><a href="mailto:centrocore.ve@gmail.com">centrocore.ve@gmail.com</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- cta-section end  -->
        <?php endif; ?>

        <!-- footer-section start  -->
        <footer class="section footer-section bg-dark">
            <div class="container">
                <!-- row start  -->
                <div class="row justify-content-between g-2">
                    <div class="col-lg-4">
                        <a class="brand-logo d-flex align-items-center" href="#home" aria-label="CORE">
                            <img src="<?php echo e(URL::asset('build/images/logo.jpg')); ?>" alt="Logo CORE" class="core-logo core-logo-footer">
                        </a>
                        <p class="mt-4 text-white-50">Atención odontológica integral con tecnología de vanguardia, especialistas y calidez humana para cuidar cada sonrisa.</p>
                        <div class="footer-btn mt-4">
                            <h5>Contacto :</h5>
                            <a href="mailto:info@corecentrove.com" class="btn btn-light">info@corecentrove.com</a>
                        </div>
                    </div>


                    <div class="col-lg-2">
                        <h5>Especialidades :</h5>
                        <ul>
                            <?php $__currentLoopData = $departments->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <a href="#services"><i class="mdi mdi-chevron-right"></i>
                                        <?php echo e($department->name); ?></a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                    <div class="col-lg-2">
                        <h5>Accesos :</h5>
                        <ul>
                            <li>
                                <a href="#home"><i class="mdi mdi-chevron-right"></i>
                                    Inicio</a>
                            </li>
                            <li>
                                <a href="#services"><i class="mdi mdi-chevron-right"></i>
                                    Especialidades</a>
                            </li>
                            <li>
                                <a href="#team"><i class="mdi mdi-chevron-right"></i>
                                    Equipo</a>
                            </li>
                            <li>
                                <a href="#contact"><i class="mdi mdi-chevron-right"></i>
                                    Contacto</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-4">
                        <h5>Contáctanos :</h5>
                        <ul>
                            <li>
                                <span class="text-white"><span class="mdi mdi-map-marker font-size-18"></span> </span> <a href="#!">Venezuela</a>
                            </li>
                            <li>
                                <span class="text-white"><span class="mdi mdi-email-outline font-size-18"></span> </span> <a href="mailto:info@corecentrove.com">info@corecentrove.com</a>
                            </li>
                            <li>
                                <span class="text-white"><span class="mdi mdi-email-outline font-size-18"></span> </span> <a href="mailto:centrocore.ve@gmail.com">centrocore.ve@gmail.com</a>
                            </li>
                        </ul>
                    </div>

                </div>
                <!-- row end  -->
            </div>
            <!-- container end  -->
        </footer>
        <!-- footer end  -->

        <!-- footer-copyright start  -->
        <div class="footer-copyright p-4">
            <div class="container">
                <div class="text-center">
                    <p class="text-white m-0"><?php echo e(date('Y')); ?> © CORE Centro Odontológico de Rehabilitación Estética</p>
                </div>
            </div>
        </div>
        <!-- footer-copyright end  -->
    </div>

    <!-- JAVASCRIPT -->
    <?php echo $__env->make('layouts.common-scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        // Initialize Swiper
        var swiper = new Swiper('.swiper', {
            slidesPerView: 2,
            spaceBetween: 15,
            loop: true,
           
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            breakpoints: {
                480: {
                    slidesPerView: 2,
                    spaceBetween: 15,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 20,
                },
                1280: {
                    slidesPerView: 6,
                    spaceBetween: 20,
                }
            }
        });
    </script>
</body>

</html>
<?php /**PATH C:\wamp64\www\appyweb\crm_clinicas\crm-clinicas\resources\views/landing/index.blade.php ENDPATH**/ ?>
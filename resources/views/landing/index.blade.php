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
    <link rel="shortcut icon" href="{{ URL::asset('build/images/') . '/' . AppSetting('favicon') }}">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    <!-- Slick Carousel CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    
    @include('layouts.head')
    <link href="{{ URL::asset('build/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/css/landing.css') }}" rel="stylesheet" type="text/css" />
</head>

<body>

    <div class="landing-page">
        <!-- header nav bar start  -->
        <header>
            <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top navbar-custom sticky sticky-light"
                id="navbar">
                <div class="container">
                    <a class="navbar-brand logo d-flex align-items-center" href="#home" aria-label="CORE">
                        <img src="{{ URL::asset('build/images/logo.png') }}" alt="Logo CORE" class="core-logo">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav mx-auto">
                            @if ($data['Home'] == 0)
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="#home">Inicio</a>
                                </li>
                            @endif
                            @if ($data['Services'] == 0)
                                <li class="nav-item">
                                    <a class="nav-link" href="#services">Especialidades</a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link" href="#brand">Nosotros</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#commitment">Compromiso</a>
                            </li>
                            @if ($data['Team'] == 0)
                                <li class="nav-item">
                                    <a class="nav-link" href="#team">Equipo</a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('doctors.find') }}">Odontólogos</a>
                            </li>
                            @if ($data['Contact'] == 0)
                                <li class="nav-item">
                                    <a class="nav-link" href="#contact">Contacto</a>
                                </li>
                            @endif
                        </ul>
                        <div class="d-flex">
                            @if (Sentinel::check())
                                <a href="{{ url('dashboard') }}" class="btn btn-sm">
                                    <i class="fas fa-user-lock me-1"></i> Panel
                                </a>
                            @else
                                <a href="{{ url('login') }}" class="btn btn-sm">
                                    <i class="fas fa-user-lock me-1"></i> Panel
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <!-- header nav bar end  -->


        <!-- home-section start -->
        @if ($data['Home'] == 0)
            <section class="core-hero-compromiso" id="home">
                <div class="core-hero-overlay"></div>
                <div class="container core-hero-grid">
                    <div class="core-hero-left">
                        <h2>Tu sonrisa es<br><span>nuestra prioridad</span></h2>
                        <p>Transformamos la experiencia dental con atención integral, tecnología moderna y un trato humano que devuelve confianza a cada sonrisa.</p>

                        <div class="core-hero-services">
                            <a href="#services" class="core-hero-service-link" aria-label="Ir a especialidad Rehabilitación Oral">
                                <article class="core-hero-service">
                                    <img src="{{ URL::asset('build/images/nuevas/icono_Rehabilitacion oral.png') }}" alt="Rehabilitación Oral">
                                    <h3>Rehabilitación<br>Oral</h3>
                                </article>
                            </a>
                            <a href="#services" class="core-hero-service-link" aria-label="Ir a especialidad Diseño de Sonrisa">
                                <article class="core-hero-service">
                                    <img src="{{ URL::asset('build/images/nuevas/icono_estetica.png') }}" alt="Diseño de Sonrisa">
                                    <h3>Diseño de<br>Sonrisa</h3>
                                </article>
                            </a>
                            <a href="#services" class="core-hero-service-link" aria-label="Ir a especialidad Ortodoncia">
                                <article class="core-hero-service">
                                    <img src="{{ URL::asset('build/images/nuevas/icono_ortodoncia.png') }}" alt="Ortodoncia">
                                    <h3>Ortodoncia</h3>
                                </article>
                            </a>
                            <a href="#services" class="core-hero-service-link" aria-label="Ir a especialidad Cirugía">
                                <article class="core-hero-service">
                                    <img src="{{ URL::asset('build/images/nuevas/icono_cirugia dental.png') }}" alt="Cirugía">
                                    <h3>Cirugía</h3>
                                </article>
                            </a>
                        </div>
                    </div>

                    <div class="core-hero-right">
                        <div class="core-hero-instagram">
                            <a href="https://www.instagram.com/core.ven" target="_blank" rel="noopener noreferrer">
                                <div class="core-hero-doctor-text">
                                    <h4>Dr. Jesus Rodriguez</h4>
                                    <p>Especialista en Rehabilitación oral y estética</p>
                                </div>
                                <div class="core-hero-handle">
                                    <span>core.ve</span>
                                    <img src="{{ URL::asset('build/images/nuevas/icono_instagram.png') }}" alt="Instagram CORE">
                                </div>
                            </a>
                        </div>

                        <div class="core-hero-cta">
                            <a href="{{ url('/find-doctor') }}" class="btn btn-primary">Agenda tu cita Aquí</a>
                        </div>
                    </div>
                </div>
            </section>
            <!-- home-section end  -->
        @endif

        @if ($data['Services'] == 0)
            <!-- services-section start  -->
            <section class="servicios-section" id="services">
                <div class="container">
                    <h2>Nuestras especialidades</h2>
                    @php
                        $specialtyIcons = [
                            'rehabilitacion' => 'icono_Rehabilitacion oral.png',
                            'diseno' => 'icono_estetica.png',
                            'estetica' => 'icono_estetica.png',
                            'ortodoncia' => 'icono_ortodoncia.png',
                            'cirugia' => 'icono_cirugia dental.png',
                            'endodoncia' => 'icono_endodoncia.png',
                            'implanto' => 'icono_implantologia.png',
                            'periodoncia' => 'icono_periodoncia.png',
                        ];
                    @endphp
                    <div class="row">
                        @foreach($departments as $department)
                            @php
                                $departmentText = mb_strtolower($department->name . ' ' . ($department->description ?? ''), 'UTF-8');
                                $selectedIcon = 'icono_endodoncia.png';
                                foreach ($specialtyIcons as $keyword => $iconFile) {
                                    if (str_contains($departmentText, $keyword)) {
                                        $selectedIcon = $iconFile;
                                        break;
                                    }
                                }
                            @endphp
                            <div class="col-lg-4 col-md-6">
                                <div class="servicio-card">
                                    <div class="servicio-icon">
                                        @php
                                            $departmentImage = $department->image ? 'build/images/nuevas/' . $department->image : 'build/images/nuevas/' . $selectedIcon;
                                        @endphp
                                        <img src="{{ URL::asset($departmentImage) }}" alt="{{ $department->name }}">
                                    </div>
                                    <h3>{{ $department->name }}</h3>
                                    <p class="servicio-description">{{ $department->description ?: 'Atención especializada con enfoque clínico integral y resultados estéticos funcionales.' }}</p>
                                    <a href="{{ route('doctors.find', ['department' => $department->id]) }}" class="btn servicio-action">Ver especialistas</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
            <!-- services-section end  -->
        @endif

        <!-- commitment-section start  -->
            <section class="CuartoBloque" id="commitment" style="background: url({{ URL::asset('build/images/nuevas/compromiso.jpeg') }}) no-repeat center center/cover;">
                <div class="containers">
                    <div class="content">
                        <div class="row">
                            <div class="col-md-12">
                                <img src="{{ URL::asset('build/images/servicio1.png') }}" alt="" style="filter: brightness(0); max-width: 100px;">
                                <h2 style="color: #000;">Tu sonrisa, nuestra prioridad</h2>
                                <p style="color: #000;">En Centro Odontológico CORE cada paciente recibe atención personalizada, respaldada por especialistas altamente capacitados y tecnología de vanguardia, en un entorno seguro, cálido y profesional.</p>
                                <div class="hero-btn mt-4">
                                    <a href="{{ url('login') }}" class="btn btn-primary">Conocer más</a>
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
                        <p>Somos una marca de profesionales confiables, cercana, elegante y moderna con un enfoque detallista que innova conocimiento y tecnología de alta gama en tecnología odontologica en cada procedimiento odontologico.</p>
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

                
                </div>
            </section>
            
        @if ($data['Team'] == 0)
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
                                @foreach($doctors as $doctor)
                                    <div class="swiper-slide">
                                        <div class="box-team">
                                            @if($doctor->user && $doctor->user->profile_photo)
                                                <img src="{{ URL::asset('storage/images/users/'.$doctor->user->profile_photo) }}" alt="Doctor Photo">
                                            @else
                                                <img src="{{ URL::asset('build/images/users/avatar-1.jpg') }}" alt="Default Photo">
                                            @endif
                                            <h4>{{ $doctor->user ? 'Dr. '.$doctor->user->first_name.' '.$doctor->user->last_name : 'Odontólogo' }}</h4>
                                            <span>{{ $doctor->department ? $doctor->department->name : 'Especialidad' }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- Add Navigation -->
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                            <!-- Add Pagination -->
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                    <div class="view-all-btn">
                        <a href="{{ route('doctors.find') }}" class="btn">Ver todos los odontólogos</a>
                    </div>
                </div>
            </section>
            <!-- doctors-section end  -->
        @endif

        

        @if ($data['Contact'] == 0)
            <!-- cta-section start  -->
            <section class="CuartoBloque" id="contact" style="background: url({{ URL::asset('build/images/nuevas/consultas.jpeg') }}) no-repeat center center/cover;">
                <div class="containers">
                    <div class="content">
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <i class="fas fa-tooth fa-3x text-brand mb-3"></i>
                                <h2>CORE <br>Centro Odontológico</h2>
                                <p class="contact-intro-text">En CORE Centro Odontológico combinamos la precisión de la odontología moderna con una atención diseñada a tu medida. Nos dedicamos a cuidar tu salud y estética dental a través de un equipo de especialistas de primer nivel, tecnología avanzada y un espacio pensado para tu total tranquilidad.</p>
                                <div class="hero-btn mt-4">
                                    <a href="{{ url('login') }}" class="btn btn-primary">Agenda una consulta</a>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <p class="contact-values-title">Valores CORE</p>
                                <div class="contact-values-grid">
                                    <article class="contact-value-card">
                                        <div class="contact-value-head">
                                            <div class="contact-value-icon"><i class="fas fa-award"></i></div>
                                            <h4>Excelencia</h4>
                                        </div>
                                        <p><strong>Buscamos la máxima calidad</strong> en cada diagnóstico, tratamiento y detalle de atención, asegurando resultados clínicos impecables.</p>
                                    </article>
                                    <article class="contact-value-card">
                                        <div class="contact-value-head">
                                            <div class="contact-value-icon"><i class="fas fa-lightbulb"></i></div>
                                            <h4>Innovación</h4>
                                        </div>
                                        <p><strong>Implementamos tecnología y técnicas de vanguardia</strong> para ofrecerte tratamientos modernos, completamente seguros y altamente eficientes.</p>
                                    </article>
                                    <article class="contact-value-card">
                                        <div class="contact-value-head">
                                            <div class="contact-value-icon"><i class="fas fa-handshake"></i></div>
                                            <h4>Compromiso</h4>
                                        </div>
                                        <p><strong>Trabajamos con dedicación absoluta</strong> para lograr resultados funcionales, estéticos y duraderos que transformen tu sonrisa.</p>
                                    </article>
                                    <article class="contact-value-card">
                                        <div class="contact-value-head">
                                            <div class="contact-value-icon"><i class="fas fa-shield-alt"></i></div>
                                            <h4>Confianza</h4>
                                        </div>
                                        <p><strong>Construimos relaciones sólidas</strong> basadas en una comunicación clara, la transparencia médica y el fiel cumplimiento de lo que prometemos.</p>
                                    </article>
                                    <article class="contact-value-card is-highlight">
                                        <div class="contact-value-head">
                                            <div class="contact-value-icon"><i class="fas fa-heart"></i></div>
                                            <h4>Calidez humana</h4>
                                        </div>
                                        <p><strong>Creamos una experiencia cercana</strong> donde cada paciente se siente verdaderamente escuchado, cómodo, valorado y en familia.</p>
                                    </article>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- cta-section end  -->
        @endif

        <!-- footer-section start  -->
        <footer class="section footer-section bg-dark">
            <div class="container">
                <!-- row start  -->
                <div class="row justify-content-between g-2">
                    <div class="col-lg-4">
                        <a class="brand-logo d-flex align-items-center" href="#home" aria-label="CORE">
                            <img src="{{ URL::asset('build/images/logo.png') }}" alt="Logo CORE" class="core-logo core-logo-footer">
                        </a>
                        <p class="mt-4 text-white-50">Atención odontológica integral con tecnología de vanguardia, especialistas y calidez humana para cuidar cada sonrisa.</p>
                        <div class="footer-btn mt-4">
                            <h5>Contacto:</h5>
                            <a href="mailto:centrocore.ve@gmail.com" class="btn btn-light">centrocore.ve@gmail.com</a>
                        </div>
                    </div>


                    <div class="col-lg-2">
                        <h5>Especialidades :</h5>
                        <ul>
                            @foreach($departments->take(6) as $department)
                                <li>
                                    <a href="#services"><i class="mdi mdi-chevron-right"></i>
                                        {{ $department->name }}</a>
                                </li>
                            @endforeach
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
                                <span class="text-white"><span class="mdi mdi-map-marker font-size-18"></span> </span> <a href="#!">C.C Gold Country, Av Country Club, Calle Urdaneta, Local PB-14</a>
                            </li>
                            <li>
                                <span class="text-white"><span class="mdi mdi-instagram font-size-18"></span> </span> <a href="https://www.instagram.com/core.ven" target="_blank" rel="noopener noreferrer">@core.ven</a>
                            </li>
                            <li>
                                <span class="text-white"><span class="mdi mdi-email-outline font-size-18"></span> </span> <a href="mailto:centrocore.ve@gmail.com">centrocore.ve@gmail.com</a>
                            </li>
                            <li>
                                <span class="text-white"><span class="mdi mdi-whatsapp font-size-18"></span> </span> <a href="https://wa.me/584248326325" target="_blank" rel="noopener noreferrer">0424-8326325</a>
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
                    <p class="text-white m-0">{{ date('Y') }} © CORE Centro Odontológico de Rehabilitación Estética</p>
                </div>
            </div>
        </div>
        <!-- footer-copyright end  -->
    </div>

    <!-- JAVASCRIPT -->
    @include('layouts.common-scripts')
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

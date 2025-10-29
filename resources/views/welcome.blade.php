<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Landing - {{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">

</head>

<body style="max-width: 90vw; overflow-x: hidden; margin: auto;background: #01241e">

    <header class="topbar">
        <div class="container d-flex align-items-center justify-content-between py-3">
            <div class="d-flex align-items-center">
                <div class="me-5" style="font-weight:700;letter-spacing:1px;">
                    <img src="{{ asset('images/landing/logo.png') }}" alt="logo"
                        style="height:40px;vertical-align:middle;" />
                </div>
                <nav class="d-none d-md-block">
                    <a class="me-3" href="#team">Equipo</a>
                    <a class="me-3" href="#mision_vision">Misión y valores</a>
                    <a class="me-3" href="#servicios">Servicios</a>
                    <a class="me-3" href="#faq">FAQ</a>
                    <a class="me-3" href="#ubicacion">Ubicación</a>
                </nav>
            </div>
            <div>
                <a class="btn btn-outline-light btn-sm" href="{{url('/login')}}">Registrarse</a>
            </div>
        </div>
    </header>

    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 text-start">
                    <h1 class="display-4 fw-bold" style="color: #C8AE80">{{ $nombreEmpresa }}</h1>
                    <p class="lead text-white-50">{{ $descripcion }}</p>
                </div>
                <div class="col-lg-6 text-end">
                    <img class="card-img" src="{{ asset('images/landing/hero-right.webp') }}" alt="justicia">
                </div>
            </div>
        </div>
    </section>

    <section id="team" class="section-team">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="fw-bold">{{ $equipoTitle }}</h2>
                <p class="text-muted">{{ $equipoDesc }}</p>
            </div>

            <div>
                <!-- Swiper -->
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        @foreach ($abogados as $abogado)
                            <div class="swiper-slide">
                                <div class="team-card text-center mx-2">
                                    <img class="team-avatar mx-auto d-block mb-3" src="{{ asset($abogado['imagen']) }}"
                                        alt="{{ $abogado['nombre'] }}">
                                    <h5 class="fw-bold">{{ $abogado['nombre'] }}</h5>
                                    <p class="text-muted small">{{ $abogado['especialidad'] }}</p>
                                </div>
                            </div>
                        @endforeach

                    </div>
                    <!-- Pagination -->
                    <div class="swiper-pagination mt-3"></div>
                    <!-- Custom Navigation -->
                    <div class="swiper-button-prev swiper-button-custom" aria-label="Anterior"></div>
                    <div class="swiper-button-next swiper-button-custom" aria-label="Siguiente"></div>
                </div>
            </div>
        </div>
    </section>

    <section id="mision_vision" class="section-mision-vision">
        <div class="image-container">
        </div>
        <div class="content-container">
            <div class="content-box">
                <h2>Mision</h2>
                <p>{{ $mision }}</p>

                <br /><br />

                <h2>Valores</h2>
                <p>{{ $vision }}</p>
            </div>
        </div>
    </section>

    <section id="servicios" class="section-servicios">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Servicios <span style="color: var(--green)">jurídicos</span></h2>
                <p class="text-muted">Ofrecemos una amplia gama de servicios jurídicos adaptados a las necesidades de
                    nuestros clientes.</p>
            </div>

            <div>
                <!-- Swiper Servicios -->
                <div class="swiper serviciosSwiper">
                    <div class="swiper-wrapper">
                        @foreach ($serviciosJuridicos as $servicioJuridico)
                            <div class="swiper-slide">
                                <div class="servicio-card mx-2">
                                    <h5 class="fw-bold">{{ $servicioJuridico['titulo'] }}</h5>
                                    <div class="servicio-descripcion collapsed">
                                        {!! $servicioJuridico['descripcion'] !!}
                                    </div>
                                    <a class="toggle-descripcion" onclick="toggleDescripcion(this)">Leer más</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Pagination -->
                    <div class="swiper-pagination mt-3"></div>
                    <!-- Custom Navigation -->
                    <div class="swiper-button-prev swiper-button-custom" aria-label="Anterior"></div>
                    <div class="swiper-button-next swiper-button-custom" aria-label="Siguiente"></div>
                </div>
            </div>
        </div>
    </section>

    <section id="faq" class="section-faq">
        <div class="container">
            <div class="row g-4 align-items-stretch">
                <div class="col-12 col-lg-7">
                    <img class="faq-image" src="{{ asset('images/landing/faq.webp') }}" alt="Atención legal" />
                </div>
                <div class="col-12 col-lg-5 d-flex">
                    <div class="faq-card w-100 d-flex flex-column">
                        <h3 class="faq-title mb-4">Preguntas <br><span>frecuentes</span></h3>

                        <div class="d-flex flex-column gap-4">
                            @foreach ($faqs as $faq)
                                <div class="faq-item">
                                    <div class="faq-number">{{ $loop->iteration }}</div>
                                    <div>
                                        <div class="faq-question">{{ $faq['pregunta'] }}</div>
                                        <div class="faq-answer">{!! $faq['respuesta'] !!}</div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mapa de Google con marcadores dinámicos -->
    <section id="ubicacion" class="section-mapa">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-12">
                <h2 class="fw-bold mb-3" style="margin-left: 2rem;">Ubicación</h2>
                <p class="text-muted mb-4" style="margin-left: 2rem;">Consulta nuestros puntos de atención.</p>
                <div id="map"></div>
            </div>
        </div>
    </section>


    <footer class="footer">
        <div class="logo-container">
            <div class="logo">
                <img src="{{ asset('images/landing/logo.png') }}" alt="logo" style="vertical-align:middle;" />
            </div>
        </div>

        <div class="divider"></div>

        <nav class="contact-bar">
            <a href="mailto:despachojuridico@gmail.com" class="contact-item">
                <i class="fa fa-thin fa fa-envelope"></i>
                <span>despachojuridico@gmail.com</span>
            </a>

            <a href="tel:503{{ $telefonoContacto }}" class="contact-item">
                <i class="fa fa-thin fa fa-phone"></i>
                <span>{{ $telefonoContacto }}</span>
            </a>

            <a href="{{ $whatsappUrl }}" class="contact-item" target="_blank">
                <i class="fa fa-brands fa fa-whatsapp"></i>
                <span>+503 {{ $telefonoContacto }}</span>
            </a>

            <div class="contact-item">
                <i class="fa fa-thin fa fa-map-location-dot"></i>
                <div class="system-info">
                    <a href="{{ $gpsOficinaCentral }}" target="_blank" style="color:inherit; text-decoration:none;">
                        Nuestra oficina central
                </div>
            </div>

            <div class="siguenos-text">
                Síguenos
            </div>

            <div class="social-links">
                <a href="{{ $instagramUrl }}" class="social-item" aria-label="Instagram" target="_blank">
                    <i class="fa fa-brands fa fa-instagram"></i>
                </a>
                <a href="{{ $tikTokUrl }}" class="social-item" aria-label="Tiktok" target="_blank">
                    <i class="fa fa-brands fa fa-tiktok"></i>
                </a>
                <a href="{{ $facebookUrl }}" class="social-item" aria-label="Facebook" target="_blank">
                    <i class="fa fa-brands fa fa-facebook-f"></i>
                </a>
                <a href="{{ $youtubeUrl }}" class="social-item" aria-label="YouTube" target="_blank">
                    <i class="fa fa-brands fa fa-youtube"></i>
                </a>
            </div>
        </nav>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <!-- Datos de ubicaciones para Google Maps -->
    <script>
        const MAP_LOCATIONS = @json($mapLocations ?? []);
    </script>

    <!-- Scripts personalizados -->
    <script src="{{ asset('js/landing.js') }}"></script>

    <!-- Google Maps JS API -->
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&callback=initMap">
    </script>
</body>

</html>

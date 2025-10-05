<!DOCTYPE html>
<html lang="es" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
    data-menu-styles="dark" data-toggled="close">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="keywords"
        content="html, html and css templates, html css and javascript, html css, html javascript, html css bootstrap, admin, bootstrap admin template, bootstrap 5 admin template, dashboard template bootstrap, admin panel template, dashboard panel, bootstrap admin, dashboard, template admin, html admin template">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/brand-logos/favicon.ico') }}" type="image/x-icon">

    <!-- Choices JS -->
    <script src="{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>

    <!-- Main Theme Js -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Bootstrap Css -->
    <link id="style" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Style Css -->
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet">

    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">

    <!-- Node Waves Css -->
    <link href="{{ asset('assets/libs/node-waves/waves.min.css') }}" rel="stylesheet">

    <!-- Simplebar Css -->
    <link href="{{ asset('assets/libs/simplebar/simplebar.min.css') }}" rel="stylesheet">

    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/@simonwep/pickr/themes/nano.min.css') }}">

    <!-- Choices Css -->
    <link rel="stylesheet" href="{{ asset('assets/libs/choices.js/public/assets/styles/choices.min.css') }}">

    <!-- FlatPickr CSS -->
    <link rel="stylesheet" href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}">

    <!-- Auto Complete CSS -->
    <link rel="stylesheet" href="{{ asset('assets/libs/@tarekraafat/autocomplete.js/css/autoComplete.css') }}">


    <style>
        /* Para mostrar el submenú expandido */
        .has-sub.is-expanded .slide-menu {
            display: block;
        }

        /* Para resaltar la opción activa */
        .side-menu__item.active {
            background-color: #f0f0f0;
            /* Cambia este color según tu diseño */
            font-weight: bold;
        }


        /* The switch - the box around the slider */
        .switch {
            position: relative;
            display: inline-block;
            width: 40px;
            /* Ajustado a un tamaño más pequeño */
            height: 20px;
            /* Ajustado a un tamaño más pequeño */
        }

        /* Hide default HTML checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            /* Ajustado para ser proporcional al nuevo tamaño */
            width: 16px;
            /* Ajustado para ser proporcional al nuevo tamaño */
            left: 2px;
            /* Ajustado para posicionar correctamente el círculo */
            bottom: 2px;
            /* Ajustado para posicionar correctamente el círculo */
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #036554;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #036554;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(20px);
            /* Ajustado al nuevo ancho del switch */
            -ms-transform: translateX(20px);
            /* Ajustado al nuevo ancho del switch */
            transform: translateX(20px);
            /* Ajustado al nuevo ancho del switch */
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 20px;
            /* Proporcional al nuevo tamaño */
        }

        .slider.round:before {
            border-radius: 50%;
        }

        .table-dark {
            background-color: #036554 !important;
            /* Este es un color gris oscuro */
            color: #fff !important;
            /* Opcional: para que el texto sea blanco y se vea bien */
        }

        .app-header {
            background: #000 !important;
        }

        /* .card{
            background: #E6F5F0 !important;
        } */
    </style>



</head>

<body>



    <!-- Loader -->
    <div id="loader">
        <img src="{{ asset('assets/images/media/loader.svg') }}" alt="">
    </div>
    <!-- Loader -->

    <div class="page">
        <!-- app-header -->
        <header class="app-header sticky" id="header">

            <!-- Start::main-header-container -->
            <div class="main-header-container container-fluid">

                <!-- Start::header-content-left -->
                <div class="header-content-left">

                    <!-- Start::header-element -->
                    <div class="header-element">
                        <div class="horizontal-logo">
                            <a href="{{ url('home') }}" class="header-logo">
                                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo Salvatier"
                                    class="login-logo">
                            </a>
                        </div>
                    </div>
                    <!-- End::header-element -->

                    <!-- Start::header-element -->
                    <div class="header-element mx-lg-0 mx-2">
                        <a aria-label="Hide Sidebar"
                            class="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle"
                            data-bs-toggle="sidebar" href="javascript:void(0);"><span></span></a>
                    </div>
                    <!-- End::header-element -->



                </div>
                <!-- End::header-content-left -->

                <!-- Start::header-content-right -->
                <ul class="header-content-right">





                    <!-- Start::header-element -->
                    <li class="header-element dropdown">
                        <!-- Start::header-link|dropdown-toggle -->
                        <a href="javascript:void(0);" class="header-link dropdown-toggle" id="mainHeaderProfile"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <div>
                                    <img src="{{ Auth::user()->photo ? asset('storage/photos/' . Auth::user()->photo) : asset('assets/images/perfil.png') }}"
                                        alt="img" class="avatar avatar-sm">

                                </div>
                                <div class="ms-2">
                                    <p class="mb-0 text-white fw-bold">{{ Auth::user()->name ?? '' }}</p>
                                    <p class="mb-0 text-white-50 small">{{ Auth::user()->email ?? '' }}</p>
                                </div>
                            </div>
                        </a>
                        <!-- End::header-link|dropdown-toggle -->
                        <ul class="main-header-dropdown dropdown-menu pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end"
                            aria-labelledby="mainHeaderProfile">
                            <li>
                                <div class="dropdown-item text-center border-bottom">
                                    <span>
                                        {{ auth()->user()->name }} {{ auth()->user()->lastname }}
                                    </span>
                                    <span
                                        class="d-block fs-12 text-muted">{{ auth()->user()->getRoleNames()->implode(', ') }}</span>
                                </div>
                            </li>
                            {{-- <li><a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal"
                                    data-bs-target="#modal-configuracion"><i
                                        class="bi bi-gear p-1 rounded-circle bg-primary-transparent ings me-2 fs-16"></i>Modo </a>
                            </li>
                            <li><a class="dropdown-item d-flex align-items-center" href="profile.html"><i
                                        class="fe fe-user p-1 rounded-circle bg-primary-transparent me-2 fs-16"></i>Profile</a>
                            </li>
                            <li><a class="dropdown-item d-flex align-items-center" href="mail.html"><i
                                        class="fe fe-mail p-1 rounded-circle bg-primary-transparent me-2 fs-16"></i>Mail
                                    Inbox</a></li>
                            <li><a class="dropdown-item d-flex align-items-center" href="file-manager.html"><i
                                        class="fe fe-database p-1 rounded-circle bg-primary-transparent klist me-2 fs-16"></i>File
                                    Manger<span class="badge bg-primary1 text-fixed-white ms-auto fs-9">2</span></a>
                            </li>

                            <li class="border-top bg-light"><a class="dropdown-item d-flex align-items-center"
                                    href="chat.html"><i
                                        class="fe fe-help-circle p-1 rounded-circle bg-primary-transparent set me-2 fs-16"></i>Help</a>
                            </li> --}}
                            <li><a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    <i
                                        class="fe fe-lock p-1 rounded-circle bg-primary-transparent ut me-2 fs-16"></i>Log
                                    Out</a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </li>
                    <!-- End::header-element -->



                </ul>
                <!-- End::header-content-right -->

            </div>
            <!-- End::main-header-container -->

        </header>
        <!-- /app-header -->
        <!-- Start::app-sidebar -->
        <aside class="app-sidebar sticky" id="sidebar">

            <!-- Start::main-sidebar-header -->
            <div class="main-sidebar-header">
                <a href="{{ url('home') }}" class="header-logo">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo Salvatier" class="login-logo">
                </a>
            </div>
            <!-- End::main-sidebar-header -->

            <!-- Start::main-sidebar -->
            <div class="main-sidebar" id="sidebar-scroll">

                <!-- Start::nav -->
                <nav class="main-menu-container nav nav-pills flex-column sub-open">
                    <div class="slide-left" id="slide-left">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                            viewBox="0 0 24 24">
                            <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                        </svg>
                    </div>
                    <ul class="main-menu">

                        @can('menu seguridad')
                            <!-- Start::slide__category -->
                            <li class="slide__category"><span class="category-name">Seguridad</span></li>
                            <!-- End::slide__category -->


                            @can('menu permisos')
                                <li class="slide" id="li-permiso">
                                    <a href="{{ url('seguridad/permission') }}" class="side-menu__item">
                                        <i class="bi bi-unlock w-6 h-6 side-menu__icon"></i>
                                        <span class="side-menu__label">Permisos</span>
                                    </a>
                                </li>
                            @endcan

                            @can('menu usuarios')
                                <li class="slide" id="li-usuario">
                                    <a href="{{ url('seguridad/user') }}" class="side-menu__item">
                                        <i class="bi bi-person w-6 h-6 side-menu__icon"></i>
                                        <span class="side-menu__label">Usuarios</span>
                                    </a>
                                </li>
                            @endcan

                            @can('menu roles')
                                <li class="slide" id="li-role">
                                    <a href="{{ url('seguridad/role') }}" class="side-menu__item">
                                        <i class="bi bi-card-checklist w-6 h-6 side-menu__icon"></i>
                                        <span class="side-menu__label">Roles</span>
                                    </a>
                                </li>
                            @endcan
                            <!-- End::slide -->
                        @endcan

                        @can('menu usuarios')
                            <li class="slide" id="li-usuario">
                                <a href="{{ route('modo_asesoria.index') }}" class="side-menu__item">
                                    <i class="bi bi-gear w-6 h-6 side-menu__icon"></i>
                                    <span class="side-menu__label">Tipos asesoria</span>
                                </a>
                            </li>
                        @endcan



                        @can('menu abogados')
                            <li class="slide__category"><span class="category-name">Administración</span></li>

                            <li class="slide" id="li-abogado">
                                <a href="{{ url('administracion/abogado') }}" class="side-menu__item">
                                    <i class="bi bi-people w-6 h-6 side-menu__icon"></i>
                                    <span class="side-menu__label">Abogados</span>
                                </a>
                            </li>
                        @endcan


                        @can('menu gestionar asesorias')
                            <li class="slide" id="li-asesoria">
                                <a href="{{ url('administracion/asesoria') }}" class="side-menu__item">
                                    <i class="bi bi-pencil-square w-6 h-6 side-menu__icon"></i>
                                    <span class="side-menu__label">Gestionar asesorias</span>
                                </a>
                            </li>
                        @endcan


                         @can('menu gestion de pagos')
                            <li class="slide" id="li-contrato">
                                <a href="{{ route('contrato.index') }}" class="side-menu__item">
                                    <i class="bi bi-folder2  w-6 h-6 side-menu__icon"></i>
                                    <span class="side-menu__label">Contratos</span>
                                </a>
                            </li>
                        @endcan

                        @can('menu gestion de pagos')
                            <li class="slide" id="li-contrato">
                                <a href="{{ route('pago.index') }}" class="side-menu__item">
                                    <i class="bi bi-currency-dollar w-6 h-6 side-menu__icon"></i>
                                    <span class="side-menu__label">Gestion de pagos</span>
                                </a>
                            </li>
                        @endcan

                        @can('menu notificaciones')
                            <li class="slide" id="li-notificacion">
                                <a href="{{ route('notificacion.index') }}" class="side-menu__item">
                                    <i class="bi bi-bell w-6 h-6 side-menu__icon"></i>
                                    <span class="side-menu__label">Notificaciones</span>
                                </a>
                            </li>
                        @endcan

                        {{-- @can('menu gestionar de contenido')
                            <li class="slide">
                                <a href="widgets.html" class="side-menu__item">
                                    <i class="bi bi-pen-fill w-6 h-6 side-menu__icon"></i>
                                    <span class="side-menu__label">Gestionar de contenido</span>
                                </a>
                            </li>
                        @endcan --}}


                        @can('menu sucursales')
                            <li class="slide">
                                <a href="{{ url('usuario/sucursales') }}" class="side-menu__item">
                                    <i class="bi bi-houses w-6 h-6 side-menu__icon"></i>
                                    <span class="side-menu__label">Sucursales</span>
                                </a>
                            </li>
                        @endcan

                        @can('menu inicio')
                            <li class="slide">
                                <a href="{{ url('/home') }}" class="side-menu__item">
                                    <i class="bi bi-house w-6 h-6 side-menu__icon"></i>
                                    <span class="side-menu__label">Inicio</span>
                                </a>
                            </li>
                        @endcan

                        @can('menu mis asesorias')
                            <li class="slide" id="li-mis-asesorias">
                                <a href="{{ url('usuario/asesoria') }}" class="side-menu__item">
                                    <i class="bi bi-card-checklist w-6 h-6 side-menu__icon"></i>
                                    <span class="side-menu__label">Mis asesorias</span>
                                </a>
                            </li>
                        @endcan

                        @can('menu pagos')
                            <li class="slide">
                                <a href="{{ url('usuario/pago/create') }}" class="side-menu__item">
                                    <i class="bi bi-currency-dollar w-6 h-6 side-menu__icon"></i>
                                    <span class="side-menu__label">Pagos</span>
                                </a>
                            </li>
                        @endcan

                        @can('menu mis notificaciones')
                            <li class="slide" id="li-mis-notificaciones">
                                <a href="{{ route('mis_notificaiones') }}" class="side-menu__item">
                                    <i class="bi bi-bell w-6 h-6 side-menu__icon"></i>
                                    <span class="side-menu__label">Mis notificaciones</span>
                                </a>
                            </li>
                        @endcan




                    </ul>
                    <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                            width="24" height="24" viewBox="0 0 24 24">
                            <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                        </svg></div>
                </nav>
                <!-- End::nav -->

            </div>
            <!-- End::main-sidebar -->

        </aside>
        <!-- End::app-sidebar -->

        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">
                <div class="page-header-breadcrumb flex-wrap gap-2">
                </div>
                @yield('content')

            </div>
        </div>
        <!-- End::app-content -->


        <!-- Footer Start -->
        <footer class="footer mt-auto py-3 bg-white text-center">
            <div class="container">
                {{-- <span class="text-muted"> Copyright © <span id="year"></span> <a href="javascript:void(0);"
                        class="text-dark fw-medium">Xintra</a>.
                    Designed with <span class="bi bi-heart-fill text-danger"></span> by <a href="javascript:void(0);">
                        <span class="fw-medium text-primary">Spruko</span>
                    </a> All
                    rights
                    reserved
                </span> --}}
            </div>
        </footer>
        <!-- Footer End -->
        <div class="modal fade" id="header-responsive-search" tabindex="-1"
            aria-labelledby="header-responsive-search" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="input-group">
                            <input type="text" class="form-control border-end-0" placeholder="Search Anything ..."
                                aria-label="Search Anything ..." aria-describedby="button-addon2">
                            <button class="btn btn-primary" type="button" id="button-addon2"><i
                                    class="bi bi-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <ul class="main-header-dropdown dropdown-menu dropdown-menu-end" data-popper-placement="none"></ul>



    <!-- Scroll To Top -->
    <div class="scrollToTop">
        <span class="arrow"><i class="ti ti-arrow-narrow-up fs-20"></i></span>
    </div>
    <div id="responsive-overlay"></div>
    <!-- Scroll To Top -->

    <!-- Popper JS -->
    <script src="{{ asset('assets/libs/@popperjs/core/umd/popper.min.js') }}"></script>

    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Defaultmenu JS -->
    <script src="{{ asset('assets/js/defaultmenu.min.js') }}"></script>

    <!-- Node Waves JS-->
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

    <!-- Sticky JS -->
    <script src="{{ asset('assets/js/sticky.js') }}"></script>

    <!-- Simplebar JS -->
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/simplebar.js') }}"></script>

    <!-- Auto Complete JS -->
    <script src="{{ asset('assets/libs/@tarekraafat/autocomplete.js/autoComplete.min.js') }}"></script>

    <!-- Color Picker JS -->
    <script src="{{ asset('assets/libs/@simonwep/pickr/pickr.es5.min.js') }}"></script>

    <!-- Date & Time Picker JS -->
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>



    <script>
        function expandMenuAndHighlightOption(menuId) {
            // Seleccionar el <li> por su id
            const menuItem = document.getElementById(menuId);
            if (!menuItem) return;

            // Cambiar el fondo del <li>
            menuItem.style.backgroundColor = '#036554';

            // Cambiar color del texto y del icono dentro del <a>
            const link = menuItem.querySelector('a.side-menu__item');
            if (link) {
                link.style.color = '#fff'; // cambia el texto principal
            }

            // Cambiar color de todos los <i> dentro del li
            const icons = menuItem.querySelectorAll('i');
            icons.forEach(icon => {
                icon.style.color = '#fff';
            });
        }
    </script>


</body>

</html>

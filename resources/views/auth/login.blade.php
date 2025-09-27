@extends('layouts.app')

@section('content')
    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Xintra - Bootstrap 5 Premium Admin & Dashboard Template </title>
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="keywords"
        content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/brand-logos/favicon.ico') }}" type="image/x-icon">

    <!-- Main Theme Js -->
    <script src="{{ asset('assets/js/authentication-main.js') }}"></script>

    <!-- Bootstrap Css -->
    <link id="style" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Style Css -->
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet">

    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">



    <body class="bg-black">



        <div class="row authentication authentication-cover-main mx-0">
            <div class="col-xxl-6 col-xl-5 col-lg-12 d-xl-flex d-none px-0 justify-content-center align-items-center"
                style="overflow: hidden;">
                <img src="{{ asset('assets/images/login_img.jpg') }}" class="img-fluid"
                    style="border-top-right-radius: 20px; border-bottom-right-radius: 20px;">
            </div>




            <div class="col-xxl-6 col-xl-7">
                <div class="row justify-content-center align-items-center h-100">
                    <div class="col-xxl-7 col-xl-9 col-lg-6 col-md-6 col-sm-8 col-12">
                        <form method="POST" action="{{ route('login') }}" class="login-form">
                            @csrf
                            <div class="card-body p-5">
                                <div class="row gy-3">
                                    <div class="col-xl-12" style="text-align: center">
                                        <img src="{{ asset('assets/images/logo.png') }}" style="max-width: 260px"
                                            alt="Logo Salvatier" class="login-logo">

                                    </div>
                                    <div class="col-xl-12">&ensp; </div>
                                    <div class="col-xl-12">
                                        <label for="email"
                                            class="form-label text-white">{{ __('Correo electrónico') }}</label>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email" autofocus
                                            placeholder="Ingresar">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-xl-12 mb-2">
                                        <label for="password" class="form-label text-white">{{ __('Contraseña') }}</label>
                                        <div class="input-group">
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                required autocomplete="current-password" placeholder="Ingresar">
                                            <span class="input-group-text toggle-password">
                                                <i class="bi bi-eye-slash-fill"></i>
                                            </span>
                                        </div>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <a href="{{ route('password.request') }}" class="forgot-password-link text-white">
                                    {{ __('Recuperar contraseña') }}
                                </a>
                                <div class="d-grid mt-4">
                                    <button type="submit"
                                        class="btn btn-primary btn-lg rounded-pill btn-wave">Ingresar</button>
                                </div>

                                <div class="d-grid mt-4">
                                    <a href="{{url('register')}}" type="button"
                                        class="btn btn-outline-primary btn-lg rounded-pill btn-wave">Crear cuenta</a>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>

        <!-- Bootstrap JS -->
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const togglePassword = document.querySelector('.toggle-password');
                const passwordInput = document.querySelector('#password');

                togglePassword.addEventListener('click', function() {
                    // Alternar el tipo de input
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    // Alternar los íconos
                    this.querySelector('i').classList.toggle('bi-eye-fill');
                    this.querySelector('i').classList.toggle('bi-eye-slash-fill');
                });
            });
        </script>

    </body>
@endsection

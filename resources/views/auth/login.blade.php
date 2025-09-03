@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            /* Esto elimina el scroll horizontal */
        }

        body {
            background-color: #000;
        }

        .h-100 {
            height: 100%;
        }

        /* Image Column Styles */
        .image-column {
            padding: 0;
            position: relative;
        }

        .login-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 20px 0 0 20px;
            filter: brightness(0.8);
        }

        /* Form Column Styles */
        .form-column {
            background-color: #000;
            padding: 2rem;
        }

        .login-form-container {
            width: 80%;
            max-width: 450px;
        }

        .login-logo {
            height: 50px;
            margin-bottom: 2rem;
        }

        .login-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 2rem;
            text-align: left;
            color: #fff;
        }

        /* Input and Label Styles */
        .form-label {
            color: #fff;
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
            display: block;
        }

        .form-control {
            background-color: #1a1a1a;
            border: 1px solid #333;
            color: #fff;
            border-radius: 8px;
            padding: 0.75rem 1rem;
        }

        .form-control::placeholder {
            color: #888;
        }

        .form-control:focus {
            background-color: #1a1a1a;
            border-color: #036554;
            box-shadow: 0 0 0 0.25rem rgba(3, 101, 84, 0.25);
            color: #fff;
        }

        .input-group-text {
            background-color: #1a1a1a;
            border: 1px solid #333;
            color: #fff;
            border-left: none;
            cursor: pointer;
            border-radius: 0 8px 8px 0;
        }

        /* Button Styles */
        .btn-login {
            background-color: #036554;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            font-weight: bold;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .btn-login:hover {
            background-color: #024a3d;
        }

        /* Link Styles */
        .forgot-password-link {
            color: #036554;
            font-size: 0.8rem;
            text-decoration: none;
            display: block;
            text-align: right;
            margin-top: 0.5rem;
        }

        .forgot-password-link:hover {
            color: #024a3d;
            text-decoration: underline;
        }

        /* Hide the remember me checkbox */
        .form-check {
            display: none;
        }
    </style>

    <div class="row h-100">
        <div class="col-md-6 d-flex align-items-center justify-content-center image-column">
            <img src="{{ asset('assets/images/login_img.jpg') }}" alt="Salvatier Abogados" class="img-fluid login-image">
        </div>
        <div class="col-md-6 d-flex align-items-center justify-content-center form-column">
            <div class="login-form-container">
                <div class="login-logo-container" style="text-align: center">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo Salvatier" class="login-logo">
                </div>
                {{-- <h2 class="login-title">Administrador</h2> --}}

                <form method="POST" action="{{ route('login') }}" class="login-form">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="email" class="form-label">{{ __('Correo electrónico') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                            placeholder="Ingresar">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>

                    <div class="form-group mb-3">
                        <label for="password" class="form-label">{{ __('Contraseña') }}</label>
                        <div class="input-group">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password" placeholder="Ingresar">
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

                    <a href="{{ route('password.request') }}" class="forgot-password-link">
                        {{ __('Recuperar contraseña') }}
                    </a>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-login">{{ __('Ingresar') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
@endsection

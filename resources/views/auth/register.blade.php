@extends('layouts.app')

@section('content')
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

        <div class="container-lg">
            <div class="row justify-content-center align-items-center authentication authentication-basic h-100">
                <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">
                    <div class="card custom-card my-4">
                        <div class="card-body p-5">
                            <p class="h5 mb-2 text-center">Registro</p>
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if (session('success'))
                                <script>
                                    toastr.success("{{ session('success') }}");
                                </script>
                            @endif

                            @if (session('error'))
                                <script>
                                    toastr.error("{{ session('error') }}");
                                </script>
                            @endif
                            <br>

                            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row gy-3">
                                    <div class="col-xl-12 d-flex flex-column align-items-center mb-4">
                                        <div class="mb-3">
                                            <span class="avatar avatar-xxl avatar-rounded d-block mx-auto">
                                                <img id="previewImage" src="{{ asset('assets/images/podcast/1.jpg') }}"
                                                    alt="Avatar">
                                            </span>
                                        </div>

                                        <button type="button" id="uploadBtn"
                                            class="btn btn-outline-primary  rounded-pill btn-wave px-4" style="display: block;">
                                            Cargar fotografía
                                        </button>

                                        <a href="javascript:void(0);" id="deleteBtn" class="btn btn-outline-danger  rounded-pill btn-wave px-4"
                                            style="display: none;">
                                            <i class="ri-delete-bin-line align-middle me-1"></i> Eliminar foto
                                        </a>

                                        <input type="file" name="photo" id="fileInput" accept="image/*"
                                            style="display: none;">

                                        @error('photo')
                                            <div class="text-danger small mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-xl-12">
                                        <label class="form-label text-default">Nombre<sup
                                                class="fs-12 text-danger">*</sup></label>
                                        <input type="text" name="name" value="{{ old('name') }}" required
                                            class="form-control">
                                        @error('name')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-xl-12">
                                        <label class="form-label text-default">Apellidos<sup
                                                class="fs-12 text-danger">*</sup></label>
                                        <input type="text" name="lastname" value="{{ old('lastname') }}" required
                                            class="form-control">
                                        @error('lastname')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-xl-12">
                                        <label class="form-label text-default">Phone<sup
                                                class="fs-12 text-danger">*</sup></label>
                                        <input type="text" name="phone" value="{{ old('phone') }}" required
                                            class="form-control">
                                        @error('phone')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-xl-12">
                                        <label class="form-label text-default">Correo electrónico<sup
                                                class="fs-12 text-danger">*</sup></label>
                                        <input type="email" name="email" value="{{ old('email') }}" required
                                            class="form-control">
                                        @error('email')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-xl-12">
                                        <label for="signup-password" class="form-label text-default">Contraseña<sup
                                                class="fs-12 text-danger">*</sup></label>
                                        <div class="position-relative">
                                            <input type="password" name="password" class="form-control" id="signup-password"
                                                required>
                                        </div>
                                        @error('password')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-xl-12">
                                        <label for="signup-confirmpassword" class="form-label text-default">Confirmar
                                            contraseña<sup class="fs-12 text-danger">*</sup></label>
                                        <div class="position-relative">
                                            <input type="password" name="password_confirmation" class="form-control"
                                                id="signup-confirmpassword" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid mt-4">
                                    <button class="btn btn-primary btn-lg rounded-pill btn-wave">Registrarse</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        const fileInput = document.getElementById('fileInput');
        const previewImage = document.getElementById('previewImage');
        const uploadBtn = document.getElementById('uploadBtn');
        const deleteBtn = document.getElementById('deleteBtn');

        // Guardamos la imagen original
        const defaultImage = "{{ asset('assets/images/podcast/1.jpg') }}";

        // Función para actualizar la visibilidad de los botones
        function updateButtonVisibility() {
            if (previewImage.src === defaultImage) {
                uploadBtn.style.display = 'block';
                deleteBtn.style.display = 'none';
            } else {
                uploadBtn.style.display = 'none';
                deleteBtn.style.display = 'block';
            }
        }

        // Al hacer click en "Cargar fotografía", abrir el file input
        uploadBtn.addEventListener('click', () => {
            fileInput.click();
        });

        // Cuando se selecciona un archivo
        fileInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    previewImage.src = e.target.result; // mostrar preview
                    updateButtonVisibility();
                };
                reader.readAsDataURL(file);
            }
        });

        // Al hacer click en "Eliminar", restaurar imagen por defecto y limpiar file
        deleteBtn.addEventListener('click', () => {
            previewImage.src = defaultImage;
            fileInput.value = ""; // limpiar input file
            updateButtonVisibility();
        });

        // Inicializar el estado de los botones al cargar la página
        document.addEventListener('DOMContentLoaded', updateButtonVisibility);
    </script>
@endsection

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
                            <br><br>

                            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row gy-3">
                                    <div class="col-xl-12 row d-flex align-items-center">
                                        <div class="col-xl-4 lh-1 mb-3 d-flex justify-content-center">
                                            <span class="avatar avatar-xxl avatar-rounded">
                                                <img id="previewImage" src="{{ asset('assets/images/podcast/1.jpg') }}"
                                                    alt="Avatar">
                                            </span>
                                        </div>
                                        <div class="col-xl-5 lh-1 mb-3">
                                            <!-- Botón que abre el input file -->
                                            <button type="button" id="uploadBtn"
                                                class="btn btn-primary me-2 btn-block rounded-pill btn-wave">
                                                Cargar fotografía
                                            </button>
                                            <!-- Input file oculto -->
                                            <input type="file" name="photo" id="fileInput" accept="image/*"
                                                style="display: none;">
                                            @error('photo')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-xl-3 lh-1 mb-3">
                                            <button type="button" id="deleteBtn"
                                                class="btn btn-primary btn-block  rounded-pill btn-wave">
                                                Eliminar
                                            </button>
                                        </div>
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
                                            <input type="password" name="password"
                                                class="form-control create-password-input" id="signup-password" required>
                                            <a href="javascript:void(0);" class="show-password-button text-muted"
                                                onclick="createpassword('signup-password',this)" id="button-addon2">
                                                <i class="ri-eye-off-line align-middle"></i>
                                            </a>
                                        </div>
                                        @error('password')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-xl-12">
                                        <label for="signup-confirmpassword" class="form-label text-default">Confirmar
                                            contraseña
                                            <sup class="fs-12 text-danger">*</sup></label>
                                        <div class="position-relative">
                                            <input type="password" name="password_confirmation"
                                                class="form-control create-password-input" id="signup-confirmpassword"
                                                required>
                                            <a href="javascript:void(0);" class="show-password-button text-muted"
                                                onclick="createpassword('signup-confirmpassword',this)"
                                                id="button-addon21">
                                                <i class="ri-eye-off-line align-middle"></i>
                                            </a>
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
                };
                reader.readAsDataURL(file);
            }
        });

        // Al hacer click en "Eliminar", restaurar imagen por defecto y limpiar file
        deleteBtn.addEventListener('click', () => {
            previewImage.src = defaultImage;
            fileInput.value = ""; // limpiar input file
        });
    </script>
@endsection

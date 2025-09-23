@extends ('menu')
@section('content')
    <!-- DataTables CSS -->
    <link href="{{ asset('assets/libs/dataTables/dataTables.bootstrap5.min.css') }}" rel="stylesheet">

    <!-- Toastr CSS -->
    <link href="{{ asset('assets/libs/toast/toastr.min.css') }}" rel="stylesheet">

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>

    <!-- Toastr JS -->
    <script src="{{ asset('assets/libs/toast/toastr.min.js') }}"></script>



    <!-- Start:: row-1 -->
    <div class="row">
        <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12"></div>
        <div class="col-xl-8">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Configuración
                    </div>

                </div>
                <div class="card-body">
                    <form method="POST" action="{{ url('seguridad/configuracion') }}">
                        @csrf
                        <div class="modal-body">

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

                            <div class="row gy-4">

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <label for="input-label" class="form-label">Costo asesoria:</label>
                                    <input type="number" step="0.01" class="form-control" name="costo_asesoria"
                                        value="{{ $configuracion->costo_asesoria }}" required>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>

                    </form>
                </div>

            </div>

        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            expandMenuAndHighlightOption('seguridadMenu', 'roleOption');
        });
    </script>
@endsection

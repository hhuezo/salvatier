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
        <div class="col-xl-9">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Gestionar asesorias
                    </div>
                    {{-- <div class="prism-toggle">
                        <button class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modal-create">Agregar</button>
                    </div> --}}
                </div>
                <div class="card-body">

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

                    <div class="table-responsive">
                        <table id="datatable-basic" class="table table-striped text-nowrap w-100">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Usuario</th>
                                    <th>Descripción</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Estado</th>
                                    <th>Tipo</th>
                                    <th>Modo</th>
                                    <th>Costo asesoria</th>
                                    <th>Fecha pago</th>
                                    <th>Id transacción</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($asesorias as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->user->name ?? '' }} {{ $item->user->lastname ?? '' }}</td>
                                        <td>{{ $item->descripcion }}</td>
                                        <td>
                                            {{ $item->fecha ? \Carbon\Carbon::parse($item->fecha)->format('d/m/Y') : '-' }}
                                        </td>

                                        <td>
                                            {{ $item->hora ? \Carbon\Carbon::parse($item->hora)->format('H:i') : '-' }}
                                        </td>
                                        <td>
                                            @if ($item->estado)
                                                @php
                                                    $color = match ($item->estado->id) {
                                                        1 => 'danger',
                                                        2 => 'warning',
                                                        3 => 'success',
                                                        4 => 'info',
                                                        5 => 'secondary',
                                                        default => 'secondary',
                                                    };
                                                @endphp
                                                <button
                                                    class="btn btn-sm btn-{{ $color }}">{{ $item->estado->nombre }}</button>
                                            @else
                                                <button class="btn btn-sm btn-secondary">-</button>
                                            @endif
                                        </td>

                                        <td>{{ $item->tipo->nombre ?? '-' }}</td>
                                        <td>{{ $item->modo->nombre ?? '-' }}</td>
                                        <td>{{ $item->costo_asesoria ? '$' . $item->costo_asesoria : '' }}</td>
                                        <td>
                                            {{ $item->fecha_pago ? \Carbon\Carbon::parse($item->fecha_pago)->format('d/m/Y') : '-' }}
                                        </td>
                                        <td>{{ $item->id_trasaccion }}</td>
                                        <td style="text-align: center">
                                            <button class="btn btn-sm btn-dark btn-wave"
                                                onclick="getDetalle({{ $item->id }})">
                                                &nbsp;Ver&nbsp;
                                            </button>
                                            {{-- @if ($item->estado_asesoria_id == 2)
                                                <button class="btn btn-sm btn-primary btn-wave">
                                                    &nbsp;<i class="bi bi-arrow-left-right"></i>&nbsp;
                                                </button>
                                            @endif --}}


                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


                    </div>
                </div>

            </div>
        </div>
        <div class="col-xl-3" id="divDetalle">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Detalle
                    </div>
                </div>

                <div class="card-body">

                    <div class="row gy-3">
                        <input type="hidden" class="form-control" id="asesoria_id" readonly>
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <span class="avatar avatar-xl bg-primary-transparent">
                                        <img src="{{ asset('assets/images/perfil.png') }}" alt="">
                                    </span>
                                </div>
                                <div>
                                    <div class="mb-1 fs-14 fw-medium">
                                        <a href="javascript:void(0);">
                                            Usuario</a>
                                    </div>
                                    <div class="mb-1">
                                        <span class="me-1 d-inline-block" id="userName"></span>
                                    </div>
                                    <div class="mb-1">
                                        <span class="me-1 d-inline-block" id="userEmail"> </span>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- Descripción -->
                        <div class="col-12">
                            <label class="form-label fw-bold">Descripción:</label>
                            <textarea class="form-control" id="descripcion" rows="3" readonly></textarea>
                        </div>

                        <!-- Tipo -->
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Tipo asesoria:</label>
                            <input type="text" class="form-control" id="tipo_asesoria" readonly>
                        </div>



                        <!-- Modo -->
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Modo asesoria:</label>
                            <input type="text" id="modo_asesoria" class="form-control" readonly>
                            <input type="hidden" id="enlace" class="form-control" readonly>
                            <input type="hidden" id="modo_asesoria_id" class="form-control" readonly>
                        </div>

                        <!-- Fecha -->
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Fecha asesoria:</label>
                            <input type="date" class="form-control" id="fecha" readonly>
                        </div>

                        <!-- Hora -->
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Hora asesoria:</label>
                            <input type="text" class="form-control" id="hora" readonly>
                        </div>

                    </div>
                </div>




            </div>
        </div>

    </div>






    <script src="{{ asset('assets/libs/dataTables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/dataTables/dataTables.bootstrap5.min.js') }}"></script>

    <!-- Activar DataTable -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            expandMenuAndHighlightOption('li-asesoria');

            $('#datatable-basic').DataTable({
                language: {
                    processing: "Procesando...",
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ registros",
                    info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                    infoFiltered: "(filtrado de un total de _MAX_ registros)",
                    infoPostFix: "",
                    loadingRecords: "Cargando...",
                    zeroRecords: "No se encontraron resultados",
                    emptyTable: "Ningún dato disponible en esta tabla",
                    paginate: {
                        first: "<<",
                        previous: "<",
                        next: ">",
                        last: ">>"
                    },
                    aria: {
                        sortAscending: ": Activar para ordenar la columna de manera ascendente",
                        sortDescending: ": Activar para ordenar la columna de manera descendente"
                    },
                    buttons: {
                        copy: 'Copiar',
                        colvis: 'Visibilidad',
                        print: 'Imprimir',
                        excel: 'Exportar Excel',
                        pdf: 'Exportar PDF'
                    }
                }
            });


        });


        function getDetalle(id) {
            fetch(`{{ url('administracion/asesoria') }}/${id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la solicitud');
                    }
                    return response.text(); // <-- recibir HTML
                })
                .then(html => {
                    document.getElementById('divDetalle').innerHTML = html; // insertar en el div
                })
                .catch(error => {
                    console.error('Ocurrió un error:', error);
                    document.getElementById('divDetalle').innerHTML =
                        '<div class="alert alert-danger">No se pudo cargar el detalle.</div>';
                });
        }
    </script>
    <!-- End:: row-1 -->
@endsection

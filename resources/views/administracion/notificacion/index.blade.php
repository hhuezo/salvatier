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
                        Notificaciones
                    </div>

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
                                    <th>Nombre</th>
                                    <th>Correo electrónico</th>
                                    <th>Fecha</th>
                                    {{-- <th>Apellidos</th>

                                    <th>Mensaje</th>
                                    <th>Archivo</th> --}}
                                    <th>Criticidad</th>
                                    <th>Activo</th>

                                    <th>Detalles</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notificaciones as $item)
                                    <tr>
                                        <td>{{ $item->user->name ?? '' }} {{ $item->user->lastname ?? '' }}</td>
                                        <td> {{ $item->user->email ?? '' }}</td>
                                        <td>{{ $item->fecha ? \Carbon\Carbon::parse($item->fecha)->format('d/m/Y') : '-' }}
                                        </td>
                                        <td>{{ $item->criticidad }}</td>
                                        <td>
                                            @if ($item->activo)
                                                <button class="btn btn-sm btn-success">Activo</button>
                                            @else
                                                <button class="btn btn-sm btn-danger">Inactivo</button>
                                            @endif
                                        </td>
                                        <td><button class="btn btn-dark  rounded-pill  btn-wave"
                                                onclick="getDetalle({{ $item->id }})">&nbsp;Ver&nbsp;</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


                    </div>
                </div>

            </div>
        </div>

        <div class="col-xxl-3" id="divDetalle">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title me-1">Detalle</div>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group mb-0 border-0 rounded-0">
                        <li class="list-group-item p-3 border-top-0">
                            <div class="d-flex align-items-center flex-wrap">
                                <span class="avatar avatar-lg bg-light me-2">
                                    <img src="../assets/images/ecommerce/png/9.png" alt="">
                                </span>
                                <div class="flex-fill">
                                    <p class="mb-0 fw-semibold"></p>
                                    <p class="mb-0 text-muted fs-12"></p>
                                </div>

                            </div>
                        </li>

                    </ul>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-primary rounded-pill  btn-wave" data-bs-toggle="modal"
                            data-bs-target="#modal-confirmar" onclick=" showConfirmar()">&nbsp;Responder&nbsp;</button>


                    </div>
                </div>


            </div>
        </div>


    </div>


    <div class="modal fade" id="modal-responder" tabindex="-1" aria-labelledby="modalCreateAbogadoLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modalCreateAbogadoLabel">Agregar abogado</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

            </div>
        </div>
    </div>






    <script src="{{ asset('assets/libs/dataTables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/dataTables/dataTables.bootstrap5.min.js') }}"></script>

    <!-- Activar DataTable -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            expandMenuAndHighlightOption('li-abogado');

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
            fetch(`{{ url('administracion/notificacion') }}/${id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la solicitud');
                    }
                    return response.text(); // recibimos como texto plano
                })
                .then(html => {
                    // Pintar el HTML recibido dentro del div
                    document.getElementById('divDetalle').innerHTML = html;
                })
                .catch(error => {
                    console.error('Ocurrió un error:', error);
                    document.getElementById('divDetalle').innerHTML =
                        '<p class="text-danger">No se pudo cargar la notificación.</p>';
                });
        }
    </script>
    <!-- End:: row-1 -->
@endsection

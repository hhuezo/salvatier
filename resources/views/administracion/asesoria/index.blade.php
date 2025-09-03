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
                                    <th>ID</th>
                                    <th>Usuario</th>
                                    <th>Descripción</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Estado</th>
                                    <th>Tipo</th>
                                    <th>Modo</th>
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
                                                        2 => 'info',
                                                        3 => 'success',
                                                        4 => 'warning',
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
                                        <td style="text-align: center">
                                            <button class="btn btn-sm btn-dark btn-wave"
                                                onclick="getDetalle({{ $item->id }})">
                                                &nbsp;Ver&nbsp;
                                            </button>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


                    </div>
                </div>

            </div>
        </div>
        <div class="col-xl-3">
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

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary rounded-pill  btn-wave" data-bs-dismiss="modal"
                        data-bs-toggle="modal" data-bs-target="#modal-reagendar"
                        onclick="showReagendar()">Reagendar</button>
                    &nbsp; &nbsp;
                    <button type="button" class="btn btn-primary rounded-pill  btn-wave" data-bs-toggle="modal"
                        data-bs-target="#modal-confirmar" onclick=" showConfirmar()">Confirmar</button>


                </div>


            </div>
        </div>

    </div>




    @include('administracion.asesoria.confirmar')
    @include('administracion.asesoria.reagendar')



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
                    return response.json();
                })
                .then(data => {
                    console.log('Detalle de Asesoría:', data);
                    document.getElementById('asesoria_id').value = data.data.id;
                    document.getElementById('userName').innerText = data.data.user.name + ' ' + data.data.user.lastname;
                    document.getElementById('userEmail').innerText = data.data.user.email;
                    document.getElementById('descripcion').value = data.data.descripcion; //
                    document.getElementById('tipo_asesoria').value = data.data.tipo.nombre;
                    document.getElementById('modo_asesoria').value = data.data.modo.nombre;
                    document.getElementById('modo_asesoria_id').value = data.data.modo.id;
                    document.getElementById('fecha').value = data.data.fecha;
                    document.getElementById('hora').value = data.data.hora;
                    document.getElementById('enlace').value = data.data.enlace;

                    // Aquí puedes actualizar tu modal o la UI con los datos
                })
                .catch(error => {
                    console.error('Ocurrió un error:', error);
                });
        }

        function showConfirmar() {
            document.getElementById('modalConfirmarId').value = document.getElementById('asesoria_id').value;
            document.getElementById('modalConfirmarName').innerText = document.getElementById('userName').innerText;
            document.getElementById('modalConfirmarEmail').innerText = document.getElementById('userEmail').innerText;
            document.getElementById('modalConfirmarDescripcion').innerText = document.getElementById('descripcion').value;
            document.getElementById('modalConfirmarTipo').value = document.getElementById('tipo_asesoria').value;
            document.getElementById('modalConfirmarModo').value = document.getElementById('modo_asesoria').value;
            document.getElementById('modalConfirmarFecha').value = document.getElementById('fecha').value;
            document.getElementById('modalConfirmarHora').value = document.getElementById('hora').value;
            document.getElementById('modalConfirmarEnlace').value = document.getElementById('enlace').value;

            const modoSelect = document.getElementById('modo_asesoria_id');
            const divEnlace = document.getElementById('divEnlace');


            if (modoSelect.value == '2') {
                divEnlace.style.display = 'block';
            } else {
                divEnlace.style.display = 'none';
            }


        }

        function showReagendar() {
            document.getElementById('modalReagendarId').value = document.getElementById('asesoria_id').value;
            document.getElementById('modalReagendarName').innerText = document.getElementById('userName').innerText;
            document.getElementById('modalReagendarEmail').innerText = document.getElementById('userEmail').innerText;
            document.getElementById('modalReagendarFecha').value = document.getElementById('fecha').value;
            document.getElementById('modalReagendarHora').value = document.getElementById('hora').value;

            const modoSelect = document.getElementById('modo_asesoria_id');
            const divEnlace = document.getElementById('divEnlace');


            if (modoSelect.value == '2') {
                divEnlace.style.display = 'block';
            } else {
                divEnlace.style.display = 'none';
            }


        }
    </script>
    <!-- End:: row-1 -->
@endsection

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
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Mis notificaciones
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
                                    <th>#</th>
                                    <th>Asesoría</th>
                                    <th>Mensaje</th>
                                    <th>Fecha</th>
                                    <th>Archivo</th>
                                    <th>Marcar como leído</th>
                                    {{-- <th>Ir a asesoria</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notificaciones as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->asesoria->descripcion ?? '-' }}</td>
                                        <td>{{ $item->mensaje }}</td>
                                        <td>{{ $item->fecha ? \Carbon\Carbon::parse($item->fecha)->format('d/m/Y') : '-' }}
                                        </td>
                                        <td>
                                            @if ($item->archivo)
                                                <a href="{{ asset('storage/notificaciones/' . $item->archivo) }}"
                                                    target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-paperclip"></i> Ver
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td>
                                            <div class="form-check form-switch" style="zoom: 1.5;">
                                                <input class="form-check-input" type="checkbox"
                                                    id="leidoSwitch{{ $item->id }}"
                                                    {{ $item->leido ? 'checked' : '' }}
                                                    onchange="toggleLeido({{ $item->id }})">
                                                <label class="form-check-label"
                                                    for="leidoSwitch{{ $item->id }}"></label>
                                            </div>
                                        </td>
                                        {{-- <td>
                                            <a href="{{ url('usuario/asesoria', $item->id) }}"
                                                class="btn btn-primary d-inline-flex align-items-center justify-content-center">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                        </td> --}}


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>



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
            expandMenuAndHighlightOption('li-mis-notificaciones');

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




        function toggleLeido(id) {
            // Generar URL usando la ruta nombrada y reemplazar ID
            let url = "{{ route('mis_notificaiones_leido', ['id' => 'ID_REEMPLAZAR']) }}";
            url = url.replace('ID_REEMPLAZAR', id);

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({}) // si necesitas enviar datos adicionales
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Notificación marcada como leída');
                    } else {
                        console.error('Error al marcar como leído');
                    }
                })
                .catch(error => console.error(error));
        }
    </script>
    <!-- End:: row-1 -->
@endsection

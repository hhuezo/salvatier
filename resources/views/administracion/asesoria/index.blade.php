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
                                            @can('confirmar asesoria')
                                                @if ($item->estado_asesoria_id == 2)
                                                    <button class="btn btn-sm btn-success btn-wave" data-bs-toggle="modal"
                                                        data-bs-target="#modal-confirmar-{{ $item->id }}">
                                                        <i class="bi bi-check-circle"></i>
                                                    </button>
                                                @endif
                                            @endcan

                                            @can('reagendar asesoria')
                                                @if ($item->estado_asesoria_id == 3 || $item->estado_asesoria_id == 4)
                                                    <button class="btn btn-sm btn-info btn-wave" data-bs-toggle="modal"
                                                        data-bs-target="#modal-reagendar-{{ $item->id }}">
                                                        <i class="bi bi-calendar-check"></i>
                                                    </button>
                                                @endif
                                            @endcan


                                        </td>
                                    </tr>
                                    @include('administracion.asesoria.modal_confirmar')
                                    @include('administracion.asesoria.modal_reagendar')
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

    </script>
    <!-- End:: row-1 -->
@endsection

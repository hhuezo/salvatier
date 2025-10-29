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
                        Gestionar contratos
                    </div>
                    <div class="prism-toggle">
                        <a href="{{ route('contrato.create') }}" class="btn btn-primary">Agregar</a>
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
                                    <th>Opciones</th>
                                    <th>#</th>
                                    <th>Empresa</th>
                                    <th>Oficina</th>
                                    <th>Monto contratado</th>
                                    <th>Primer abono</th>
                                    <th>Pago mínimo</th>
                                    <th>Número de cuotas</th>
                                    <th>Tipo pago</th>
                                    <th>Detalle</th>
                                    <th>Fecha contrato</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contratos as $item)
                                    <tr>
                                        <td style="text-align: center">
                                            <a href="{{ route('contrato.show', $item) }}"
                                                class="btn btn-sm btn-info btn-wave">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                        </td>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->empresa->nombre ?? '-' }}</td>
                                        <td>{{ $item->oficina->nombre ?? '-' }}</td>
                                        <td>${{ number_format($item->monto_contratado, 2) }}</td>
                                        <td>{{ $item->primer_abono ? '$' . number_format($item->primer_abono, 2) : '-' }}
                                        </td>
                                        <td>{{ $item->pago_minimo ? '$' . number_format($item->pago_minimo, 2) : '-' }}
                                        </td>
                                        <td>{{ $item->numero_cuotas ?? '-' }}</td>
                                        <td>{{ $item->tipo_pago->nombre ?? '-' }}</td>
                                        <td>{{ $item->detalle ?? '-' }}</td>
                                        <td>{{ $item->fecha_contrato ? \Carbon\Carbon::parse($item->fecha_contrato)->format('d/m/Y') : '-' }}
                                        </td>
                                        <td>
                                            @if ($item->estado_contrato_id)
                                                @php
                                                    $color = match ($item->estado_contrato_id) {
                                                        1 => 'info',
                                                        2 => 'success',
                                                        3 => 'danger',
                                                        default => 'secondary',
                                                    };
                                                @endphp
                                                <button
                                                    class="btn btn-sm btn-{{ $color }}">{{ $item->estado_contrato->nombre }}</button>
                                            @else
                                                <button class="btn btn-sm btn-secondary">-</button>
                                            @endif
                                        </td>

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
            expandMenuAndHighlightOption('li-contrato');

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

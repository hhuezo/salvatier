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
                        Gestionar pagos
                        {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') ?? '—' }} -
                        {{ \Carbon\Carbon::parse($fechaFinal)->format('d/m/Y') ?? '—' }}
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modalFiltroFechas">
                            Filtrar por fechas
                        </button>
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
                        <table id="datatable-basic" class="table  text-nowrap w-100">
                            <thead class="table-dark">
                                <tr>
                                    <th>Opciones</th>
                                    <th>Empresa</th>
                                    <th>Oficina</th>
                                    <th>No Pago</th>
                                    <th>Fecha</th>
                                    <th>Cantidad</th>
                                    <th>Observación</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pagos as $item)
                                    @php
                                        // Determinar si está vencido
                                        $vencido = !$item->finalizado && $item->fecha < \Carbon\Carbon::tomorrow();

                                        // Definir clase de fila
                                        $filaClase = $item->finalizado
                                            ? 'table-success'
                                            : ($vencido
                                                ? 'table-danger'
                                                : '');

                                        // Definir estado y color de badge
                                        if ($item->finalizado) {
                                            $estado = 'Pagado';
                                            $color = 'success';
                                        } elseif ($vencido) {
                                            $estado = 'Vencido';
                                            $color = 'danger';
                                        } else {
                                            $estado = 'Pendiente';
                                            $color = 'secondary';
                                        }
                                    @endphp

                                    <tr class="{{ $filaClase }}">
                                        <td style="text-align: center">
                                            <a href="{{ route('contrato.show', $item->contrato_id) }}"
                                                class="btn btn-sm btn-info btn-wave">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                        </td>
                                        <td>{{ $item->contrato->empresa->nombre ?? '-' }}</td>
                                        <td>{{ $item->contrato->oficina->nombre ?? '-' }}</td>
                                        <td>{{ $item->numero }}</td>
                                        <td>{{ $item->fecha ? \Carbon\Carbon::parse($item->fecha)->format('d/m/Y') : '-' }}
                                        </td>
                                        <td>${{ number_format($item->cantidad, 2) }}</td>
                                        <td>{{ $item->observacion ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $color }}">{{ $estado }}</span>
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



    <!-- Modal de filtro -->
    <div class="modal fade" id="modalFiltroFechas" tabindex="-1" aria-labelledby="modalFiltroFechasLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="GET" action="{{ route('pago.index') }}">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLgLabel">Filtrar pagos por fecha</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="fechaInicio" class="form-label">Fecha inicio</label>
                            <input type="date" name="fechaInicio" id="fechaInicio" class="form-control" required
                                value="{{ $fechaInicio ?? now()->startOfMonth()->subMonths(2)->format('Y-m-d') }}">
                        </div>
                        <div class="mb-3">
                            <label for="fechaFinal" class="form-label">Fecha final</label>
                            <input type="date" name="fechaFinal" id="fechaFinal" class="form-control" required
                                value="{{ $fechaFinal ?? now()->endOfMonth()->format('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="{{ asset('assets/libs/dataTables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/dataTables/dataTables.bootstrap5.min.js') }}"></script>


    <script src="{{ asset('assets/libs/dataTables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/libs/dataTables/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/dataTables/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/libs/dataTables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/libs/dataTables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/libs/dataTables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/dataTables/buttons.print.min.js') }}"></script>

    <!-- Activar DataTable -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            expandMenuAndHighlightOption('li-pago');





            var table = $('#datatable-basic').DataTable({
                ordering: false,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="ri-file-excel-2-line"></i> Excel',
                        className: 'btn btn-success btn-sm',
                        filename: 'estado_pago',
                        title: 'Estado de pagos',
                        exportOptions: {
                            columns: ':visible:not(:first-child)',
                           // columns: ':visible',
                            // Forzar encabezados limpios
                            format: {
                                header: function(data, columnIdx) {
                                    // Devuelve manualmente los encabezados deseados
                                    const headers = [
                                        'Opciones',
                                        'Empresa',
                                        'Oficina',
                                        '# pago',
                                        'Fecha',
                                        'Cantidad',
                                        'Observación',
                                        'Estado'
                                    ];
                                    return headers[columnIdx] || '';
                                }
                            }
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="ri-file-pdf-2-line"></i> PDF',
                        className: 'btn btn-danger btn-sm',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        filename: 'estado_pago',
                        title: 'Estado de pagos',
                        exportOptions: {
                            columns: ':visible:not(:first-child)',
                            format: {
                                header: function(data, columnIdx) {
                                    const headers = [
                                        'Opciones',
                                        'Empresa',
                                        'Oficina',
                                        '# pago',
                                        'Fecha',
                                        'Cantidad',
                                        'Observación',
                                        'Estado'
                                    ];
                                    return headers[columnIdx] || '';
                                }
                            }
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="ri-printer-line"></i> Imprimir',
                        className: 'btn btn-secondary btn-sm',
                        exportOptions: {
                            columns: ':visible:not(:first-child)',
                            format: {
                                header: function(data, columnIdx) {
                                    const headers = [
                                        'Opciones',
                                        'Empresa',
                                        'Oficina',
                                        '# pago',
                                        'Fecha',
                                        'Cantidad',
                                        'Observación',
                                        'Estado'
                                    ];
                                    return headers[columnIdx] || '';
                                }
                            }
                        }
                    }
                ],
                language: {
                    processing: "Procesando...",
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ registros",
                    info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                    infoFiltered: "(filtrado de un total de _MAX_ registros)",
                    loadingRecords: "Cargando...",
                    zeroRecords: "No se encontraron resultados",
                    emptyTable: "Ningún dato disponible en esta tabla",
                    paginate: {
                        first: "<<",
                        previous: "<",
                        next: ">",
                        last: ">>"
                    },
                    buttons: {
                        copy: 'Copiar',
                        colvis: 'Visibilidad',
                        print: 'Imprimir',
                        excel: 'Exportar Excel',
                        pdf: 'Exportar PDF'
                    }
                },
                initComplete: function() {
                    var api = this.api();

                    // Columnas donde queremos select (Empresa, Oficina, Estado)
                    [1, 2, 7].forEach(function(colIndex) {
                        var column = api.column(colIndex);
                        var header = $(column.header());
                        var title = header.text(); // Guardamos el título original
                        header.empty(); // Limpiamos el encabezado

                        // Creamos el select
                        var select = $(
                                '<select class="form-select"><option value="">Todos</option></select>'
                            )
                            .appendTo(header)
                            .on('change', function() {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                column.search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                            });

                        // Llenamos los valores únicos
                        column.data().unique().sort().each(function(d) {
                            d = $('<div>').html(d).text();
                            if (d) select.append('<option value="' + d + '">' + d +
                                '</option>');
                        });

                        // Mostramos el título original encima del select
                        header.prepend('<div style="font-weight:bold; font-size:13px;">' +
                            title + '</div>');
                    });
                }
            });




        });
    </script>
    <!-- End:: row-1 -->
@endsection

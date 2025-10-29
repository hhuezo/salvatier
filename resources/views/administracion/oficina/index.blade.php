@extends ('menu')
@section('content')
<link href="{{ asset('assets/libs/dataTables/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/libs/toast/toastr.min.css') }}" rel="stylesheet">
<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/libs/toast/toastr.min.js') }}"></script>

<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">Oficina</div>
                <div class="prism-toggle">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-create">Agregar</button>
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
                    <script>toastr.success("{{ session('success') }}");</script>
                @endif
                @if (session('error'))
                    <script>toastr.error("{{ session('error') }}");</script>
                @endif

                <div class="table-responsive">
                    <table id="datatable-basic" class="table table-striped text-nowrap w-100">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Ubicación</th>
                                <th>Activo</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($oficina as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->nombre }}</td>
                                    <td>{{ $item->direccion }}</td>
                                    <td>{{ $item->telefono }}</td>
                                    <td>{{ $item->ubicacion }}</td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" {{ $item->activo == 1 ? 'checked' : '' }}
                                                onchange="toggleUserActive({{ $item->id }})">
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info btn-wave" data-bs-toggle="modal"
                                            data-bs-target="#modal-edit-{{ $item->id }}">
                                            <i class="ri-edit-line"></i>
                                        </button>
                                    </td>
                                </tr>
                                @include('administracion.oficina.edit')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal crear --}}
<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="createModoAsesoriaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Crear Oficina</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form method="POST" action="{{ route('oficina.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row gy-4">
                        <div class="col-12">
                            <label class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Dirección</label>
                            <textarea name="direccion" class="form-control" required>{{ old('direccion') }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Teléfono</label>
                            <input type="text" class="form-control" name="telefono" value="{{ old('telefono') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Ubicación</label>
                            <input type="text" class="form-control" name="ubicacion" value="{{ old('ubicacion') }}">
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

<script src="{{ asset('assets/libs/dataTables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/dataTables/dataTables.bootstrap5.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        expandMenuAndHighlightOption('li-oficina');

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
                }
            }
        });
    });
</script>
@endsection

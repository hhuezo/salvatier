@extends('menu')
@section('content')


    <!-- Toastr CSS -->
    <link href="{{ asset('assets/libs/toast/toastr.min.css') }}" rel="stylesheet">

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>

    <!-- Toastr JS -->
    <script src="{{ asset('assets/libs/toast/toastr.min.js') }}"></script>


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

    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    Servicio
                </div>
                <div class="prism-toggle">
                    <a href="{{ route('pago.index') }}">
                        <button class="btn btn-primary"><i class="bi bi-arrow-90deg-left"></i></button>
                    </a>
                </div>
            </div>
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row gy-3">
                    <div class="col-md-3">
                        <label class="form-label" for="fecha_contrato">Fecha contrato</label>
                        <input type="date" name="fecha_contrato" id="fecha_contrato" class="form-control"
                            value="{{ $servicio->fecha_contrato ?? '' }}" disabled>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label" for="tipo_pago_id">Tipo pago</label>
                        <input type="text" class="form-control" value="{{ $servicio->tipo_pago->nombre ?? '-' }}"
                            disabled>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="empresa_id">Empresa</label>
                        <input type="text" class="form-control" value="{{ $servicio->empresa->nombre ?? '-' }}" disabled>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label" for="monto_contratado">Monto contratado</label>
                        <input type="number" step="0.01" name="monto_contratado" id="monto_contratado"
                            class="form-control" value="{{ $servicio->monto_contratado ?? '' }}" disabled>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label" for="primer_abono">Primer abono</label>
                        <input type="number" step="0.01" name="primer_abono" id="primer_abono" class="form-control"
                            value="{{ $servicio->primer_abono ?? '0.00' }}" disabled>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label" for="pago_minimo">Pago mínimo</label>
                        <input type="number" step="0.01" name="pago_minimo" id="pago_minimo" class="form-control"
                            value="{{ $servicio->pago_minimo ?? '0.00' }}" disabled>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label" for="numero_cuotas">Número de cuotas</label>
                        <input type="number" step="1" name="numero_cuotas" id="numero_cuotas" class="form-control"
                            value="{{ $servicio->numero_cuotas ?? '' }}" disabled>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label" for="oficina_id">Oficina</label>
                        <input type="text" class="form-control" value="{{ $servicio->oficina->nombre ?? '-' }}"
                            disabled>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label" for="fecha_primer_pago">Fecha primer pago</label>
                        <input type="date" name="fecha_primer_pago" id="fecha_primer_pago" class="form-control"
                            value="{{ $servicio->fecha_primer_pago ?? '' }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="detalle">Detalle pago</label>
                        <textarea name="detalle" id="detalle" class="form-control" disabled>{{ $servicio->detalle ?? '' }}</textarea>
                    </div>


                </div>

                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Pagos
                    </div>
                    <div class="prism-toggle">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-create"><i
                                class="bi bi-plus-circle"></i></button>
                    </div>
                </div>
                <table class="table table-bordered table-striped  table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Fecha Pago</th>
                            <th scope="col">Monto</th>
                            <th scope="col">Observación</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = 0;
                        @endphp

                        @foreach ($servicio->pagos as $pago)
                            @php
                                $total += $pago->cantidad;
                            @endphp
                            <tr class="{{ $pago->finalizado ? 'table-success' : '' }}">
                                <th scope="row">{{ $pago->numero }}</th>
                                <td>{{ $pago->fecha ? \Carbon\Carbon::parse($pago->fecha)->format('d/m/Y') : '-' }}</td>
                                <td>${{ number_format($pago->cantidad, 2) }}</td>
                                <td>{{ $pago->observacion }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info btn-wave" data-bs-toggle="modal"
                                        data-bs-target="#modal-edit-{{ $pago->id }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    @if ($pago->finalizado != true)
                                        <button class="btn btn-sm btn-danger btn-wave" data-bs-toggle="modal"
                                            data-bs-target="#modal-delete-{{ $pago->id }}">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    @endif

                                </td>
                            </tr>

                            @include('administracion.servicio.pago_modal_edit')
                            @include('administracion.servicio.pago_modal_delete')
                        @endforeach

                        <tr>
                            <th colspan="2" class="text-end">Total</th>
                            <th>${{ number_format($total, 2) }}</th>
                            <th>
                            </th>
                            <th>
                            </th>
                        </tr>

                    </tbody>


                </table>


            </div>


        </div>
    </div>

    <div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="modalCreatePagoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modalCreatePagoLabel">Registrar Pago</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <form method="POST" action="{{ url('administracion/pago') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row gy-3">
                            <div class="col-md-6">
                                <input type="hidden" name="servicio_id" value="{{ $servicio->id }}">
                                <label for="numero" class="form-label">Número</label>
                                <input type="number" class="form-control @error('numero') is-invalid @enderror"
                                    name="numero" id="numero" value="{{ old('numero') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="fecha" class="form-label">Fecha</label>
                                <input type="date" class="form-control @error('fecha') is-invalid @enderror"
                                    name="fecha" id="fecha" value="{{ old('fecha') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="cantidad" class="form-label">Monto</label>
                                <input type="number" step="0.01"
                                    class="form-control @error('cantidad') is-invalid @enderror" name="cantidad"
                                    id="cantidad" value="{{ old('cantidad') }}" required>
                            </div>

                            <div class="col-md-6 d-flex align-items-center mt-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="finalizado" id="finalizado"
                                        value="1">
                                    <label class="form-check-label" for="finalizado">Finalizado</label>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label for="observacion" class="form-label">Observacion</label>
                                <textarea class="form-control @error('observacion') is-invalid @enderror" name="observacion" id="observacion">{{ old('observacion') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            expandMenuAndHighlightOption('li-pago');


        });
    </script>
@endsection

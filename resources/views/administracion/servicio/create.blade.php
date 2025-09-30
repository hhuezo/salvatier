@extends('menu')
@section('content')
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    NUEVO SERVICIO
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

                <form method="POST" action="{{ route('servicio.store') }}">
                    @csrf
                    <div class="row gy-3">
                        <div class="col-md-3">
                            <label class="form-label" for="fecha_contrato">Fecha contrato</label>
                            <input type="date" name="fecha_contrato" id="fecha_contrato" class="form-control"
                                value="{{ old('fecha_contrato', date('Y-m-d')) }}" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="tipo_pago_id">Tipo pago</label>
                            <select name="tipo_pago_id" id="tipo_pago_id" class="form-select" required>
                                <option value="">Seleccione</option>
                                @foreach ($tipos_pago as $tipo_pago)
                                    <option value="{{ $tipo_pago->id }}"
                                        {{ old('tipo_pago_id') == $tipo_pago->id ? 'selected' : '' }}>
                                        {{ $tipo_pago->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="empresa_id">Empresa</label>
                            <select name="empresa_id" id="empresa_id" class="form-select" required>
                                <option value="">Seleccione</option>
                                @foreach ($empresas as $empresa)
                                    <option value="{{ $empresa->id }}"
                                        {{ old('empresa_id') == $empresa->id ? 'selected' : '' }}>
                                        {{ $empresa->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="monto_contratado">Monto contratado</label>
                            <input type="number" step="0.01" name="monto_contratado" id="monto_contratado"
                                class="form-control" value="{{ old('monto_contratado') }}" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="primer_abono">Primer abono</label>
                            <input type="number" step="0.01" name="primer_abono" id="primer_abono" class="form-control"
                                value="{{ old('primer_abono') }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="pago_minimo">Pago mínimo</label>
                            <input type="number" step="0.01" name="pago_minimo" id="pago_minimo" class="form-control"
                                value="{{ old('pago_minimo') }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="numero_cuotas">Número de cuotas</label>
                            <input type="number" step="1" name="numero_cuotas" id="numero_cuotas"
                                class="form-control" value="{{ old('numero_cuotas') }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="oficina_id">Oficina</label>
                            <select name="oficina_id" id="oficina_id" class="form-select" required>
                                <option value="">Seleccione</option>
                                @foreach ($oficinas as $oficina)
                                    <option value="{{ $oficina->id }}"
                                        {{ old('oficina_id') == $oficina->id ? 'selected' : '' }}>
                                        {{ $oficina->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="fecha_primer_pago">Fecha primer pago</label>
                            <input type="date" name="fecha_primer_pago" id="fecha_primer_pago" class="form-control"
                                value="{{ old('fecha_primer_pago') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="detalle">Detalle pago</label>
                            <textarea name="detalle" id="detalle" class="form-control">{{ old('detalle') }}</textarea>
                        </div>

                    </div>

                    <div class="card-footer mt-4 text-end">
                        <button type="button" class="btn btn-primary" onclick="getPagos()">Guardar</button>
                        {{-- <button type="submit" class="btn btn-primary">Guardar</button> --}}
                    </div>
                </form>



                <div id="divResponse">
                </div>

            </div>


        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            expandMenuAndHighlightOption('li-pago');
        });

        function getPagos() {
            const fechaContrato = document.getElementById('fecha_contrato').value;
            const tipoPagoId = document.getElementById('tipo_pago_id').value;
            const empresaId = document.getElementById('empresa_id').value;
            const montoContratado = document.getElementById('monto_contratado').value;
            const primerAbono = document.getElementById('primer_abono').value;
            const pagoMinimo = document.getElementById('pago_minimo').value;
            const numeroCuotas = document.getElementById('numero_cuotas').value;
            const oficinaId = document.getElementById('oficina_id').value;
            const fechaPrimerPago = document.getElementById('fecha_primer_pago').value;
            const detalle = document.getElementById('detalle').value;

            const params = new URLSearchParams({
                fecha_contrato: fechaContrato,
                tipo_pago_id: tipoPagoId,
                empresa_id: empresaId,
                monto_contratado: montoContratado,
                primer_abono: primerAbono,
                pago_minimo: pagoMinimo,
                numero_cuotas: numeroCuotas,
                oficina_id: oficinaId,
                fecha_primer_pago: fechaPrimerPago,
                detalle: detalle
            });

            fetch("{{ route('pago.previsualizacion') }}?" + params.toString())
                .then(response => response.text())
                .then(html => {
                    document.getElementById('divResponse').innerHTML = html;
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('divResponse').innerHTML =
                        '<p class="text-danger">Ocurrió un error al cargar la previsualización.</p>';
                });
        }
    </script>
@endsection

<div class="modal fade" id="modal-edit-{{ $pago->id }}" tabindex="-1" aria-labelledby="modalEditPagoLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modalEditPagoLabel">Modificar Pago #{{ $pago->numero }}</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <form method="POST" action="{{ url('administracion/pago/' . $pago->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row gy-3">
                        <!-- Número -->
                        <div class="col-md-6">
                            <label for="numero-{{ $pago->id }}" class="form-label">Número</label>
                            <input type="number" class="form-control @error('numero') is-invalid @enderror"
                                name="numero" id="numero-{{ $pago->id }}"
                                value="{{ old('numero', $pago->numero) }}" required>
                        </div>

                        <!-- Fecha -->
                        <div class="col-md-6">
                            <label for="fecha-{{ $pago->id }}" class="form-label">Fecha</label>
                            <input type="date" class="form-control @error('fecha') is-invalid @enderror"
                                name="fecha" id="fecha-{{ $pago->id }}" value="{{ old('fecha', $pago->fecha) }}"
                                required>
                        </div>

                        <!-- Monto -->
                        <div class="col-md-6">
                            <label for="cantidad-{{ $pago->id }}" class="form-label">Monto</label>
                            <input type="number" step="0.01"
                                class="form-control @error('cantidad') is-invalid @enderror" name="cantidad"
                                id="cantidad-{{ $pago->id }}" value="{{ old('cantidad', $pago->cantidad) }}"
                                required>
                        </div>

                        <!-- Finalizado -->
                        <div class="col-md-6 d-flex align-items-center mt-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="finalizado"
                                    id="finalizado-{{ $pago->id }}" value="1"
                                    {{ $pago->finalizado ? 'checked' : '' }}>
                                <label class="form-check-label" for="finalizado-{{ $pago->id }}">Finalizado</label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="observacion-{{ $pago->id }}" class="form-label">Observacion</label>
                            <textarea class="form-control" name="observacion">{{ $pago->observacion }}</textarea>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

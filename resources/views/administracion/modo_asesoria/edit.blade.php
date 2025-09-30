<div class="modal fade" id="modal-edit-{{ $item->id }}" tabindex="-1"
    aria-labelledby="editModoAsesoriaLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="editModoAsesoriaLabel{{ $item->id }}">Editar modo de asesoría</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <form method="POST" action="{{ route('modo_asesoria.update', $item->id) }}">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="row gy-4">
                        <div class="col-12">
                            <label class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="nombre" value="{{ $item->nombre }}"
                                required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Costo</label>
                            <input type="number" class="form-control" name="costo" value="{{ $item->costo }}"
                                step="0.01" min="0" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

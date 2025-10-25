<div class="modal fade" id="modal-edit-{{ $item->id }}" tabindex="-1"
    aria-labelledby="editModoAsesoriaLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="editModoAsesoriaLabel{{ $item->id }}">Editar Oficina</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <form method="POST" action="{{ route('oficina.update', $item->id) }}">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="row gy-4">
                        <div class="col-12">
                            <label class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="nombre" value="{{ $item->nombre }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Dirección</label>
                            <textarea name="direccion" class="form-control" required>{{ $item->direccion }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Teléfono</label>
                            <input type="text" class="form-control" name="telefono" value="{{ $item->telefono }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Ubicación</label>
                            <input type="text" class="form-control" name="ubicacion" value="{{ $item->ubicacion }}">
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

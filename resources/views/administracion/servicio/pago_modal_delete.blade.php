<div class="modal fade" id="modal-delete-{{ $pago->id }}" tabindex="-1" aria-labelledby="modalDeletePagoLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modalDeletePagoLabel">Eliminar Pago #{{ $pago->numero }}</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <form method="POST" action="{{ url('administracion/pago/' . $pago->id) }}">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>¿Está seguro que desea eliminar el pago <strong>#{{ $pago->numero }}</strong>?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edit-{{$item->id}}" tabindex="-1" aria-labelledby="modalEditAbogadoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modalEditAbogadoLabel">Modificar Operador</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <form method="POST" action="{{ url('administracion/operador/'.$item->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row gy-3">
                        <!-- Nombre -->
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name', $item->name) }}" required>
                        </div>

                        <!-- Apellidos -->
                        <div class="col-md-6">
                            <label for="lastname" class="form-label">Apellidos</label>
                            <input type="text" class="form-control @error('lastname') is-invalid @enderror"
                                name="lastname" value="{{ old('lastname', $item->lastname) }}" required>
                        </div>

                        <!-- Correo -->
                        <div class="col-md-6">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email', $item->email) }}" required>
                        </div>

                        <!-- Contraseña (opcional) -->
                        <div class="col-md-6">
                            <label for="password" class="form-label">Contraseña (dejar en blanco para no cambiar)</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" placeholder="Ingresar nueva contraseña">
                        </div>

                        <!-- Estado activo -->
                        <div class="col-md-6">
                            <label for="active" class="form-label">Estado</label>
                            <select class="form-select" name="active" required>
                                <option value="1" {{ $item->active == 1 ? 'selected' : '' }}>Activo</option>
                                <option value="0" {{ $item->active == 0 ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

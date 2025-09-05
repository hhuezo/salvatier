<div class="modal fade" id="modal-reagendar" tabindex="-1" aria-labelledby="modalViewAsesoriaLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modalViewAsesoriaLabel">Reagendar asesoria</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form method="POST" action="{{ url('administracion/asesoria/reagendar') }}">
                @csrf
                <div class="modal-body">
                    <div class="row gy-3">

                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <span class="avatar avatar-xl bg-primary-transparent">
                                        <img src="{{ asset('assets/images/perfil.png') }}" alt="">
                                    </span>
                                </div>
                                <div>
                                    <div class="mb-1 fs-14 fw-medium">
                                        <a href="javascript:void(0);">
                                            Usuario</a>
                                    </div>
                                    <div class="mb-1">
                                        <span class="me-1 d-inline-block" id="modalReagendarName"></span>
                                    </div>
                                    <div class="mb-1">
                                        <span class="me-1 d-inline-block" id="modalReagendarEmail"></span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Fecha -->
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Fecha asesoria:</label>
                            <input type="hidden" name="id" id="modalReagendarId" class="form-control" required>
                            <input type="date" name="fecha" id="modalReagendarFecha" class="form-control" required>
                        </div>

                        <!-- Hora -->
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Hora asesoria:</label>
                            <input type="time" name="hora" id="modalReagendarHora" class="form-control" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Comentario:</label>
                            <textarea class="form-control" name="comentario" rows="3" readonly></textarea>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary rounded-pill  btn-wave"
                        data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary rounded-pill  btn-wave"
                        data-bs-dismiss="modal">Reagendar</button>
                </div>
            </form>
        </div>
    </div>
</div>

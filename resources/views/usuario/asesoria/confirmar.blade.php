<div class="modal fade" id="modal-confirmar" tabindex="-1" aria-labelledby="modalViewAsesoriaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modalViewAsesoriaLabel">Confirmar asesoria</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <form method="POST" action="{{ url('administracion/asesoria/confirmar') }}">
                @csrf
                <div class="modal-body">
                    <div class="row gy-3">
                        <input type="hidden" class="form-control" name="id" id="modalConfirmarId" readonly>
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
                                        <span class="me-1 d-inline-block" id="modalConfirmarName"></span>
                                    </div>
                                    <div class="mb-1">
                                        <span class="me-1 d-inline-block" id="modalConfirmarEmail"></span>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- Descripción -->
                        <div class="col-12">
                            <label class="form-label fw-bold">Descripción:</label><br>
                            <span class="me-1 d-inline-block" id="modalConfirmarDescripcion"></span>
                        </div>

                        <!-- Tipo -->
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Tipo asesoria:</label>
                            <input type="text" class="form-control" id="modalConfirmarTipo" readonly>
                        </div>



                        <!-- Modo -->
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Modo asesoria:</label>
                            <input type="text" class="form-control" id="modalConfirmarModo" readonly>
                        </div>

                        <!-- Fecha -->
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Fecha asesoria:</label>
                            <input type="date" class="form-control" id="modalConfirmarFecha" readonly>
                        </div>

                        <!-- Hora -->
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Hora asesoria:</label>
                            <input type="time" class="form-control" id="modalConfirmarHora" readonly>
                        </div>

                        <div class="col-md-12" id="divEnlace" style="display: none;">
                            <label class="form-label fw-bold">Adjuntar enlace de asesoria:</label>
                            <input type="text" class="form-control" name="enlace" id="modalConfirmarEnlace">
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary rounded-pill  btn-wave"
                        data-bs-dismiss="modal">&nbsp;Cancelar&nbsp;</button>
                    <button type="submit" class="btn btn-primary rounded-pill  btn-wave"
                        data-bs-dismiss="modal">&nbsp;&nbsp;Enviar&nbsp;&nbsp;</button>


                </div>
            </form>
        </div>
    </div>
</div>

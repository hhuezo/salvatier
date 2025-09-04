<div class="card custom-card">
    <div class="card-header">
        <div class="card-title me-1">Detalle</div>
    </div>
    <div class="card-body p-0">
        <ul class="list-group mb-0 border-0 rounded-0">
            <li class="list-group-item p-3 border-top-0">
                <div class="d-flex align-items-center flex-wrap">
                    <span class="avatar avatar-lg bg-light me-2">
                        <img src="{{ asset('assets/images/perfil.png') }}" alt="">
                    </span>
                    <div class="flex-fill">
                        <p class="mb-0 fw-semibold">Usuario</p>
                        <p class="mb-0 text-muted fs-12">{{ $notificacion->user->name ?? '' }}
                            {{ $notificacion->user->lastname ?? '' }}</p>
                        <p class="mb-0 text-muted fs-12">{{ $notificacion->user->email ?? '' }}</p>
                    </div>

                </div>
            </li>

        </ul>
        <div class="p-3 border-bottom border-block-end-dashed">
            <div class="d-flex align-items-center justify-content-between flex-wrap">
                <div class="fs-12 fw-semibold bg-primary-transparent badge badge-md rounded">
                    {{ $notificacion->created_at ? $notificacion->created_at->format('d/m/Y') : '' }}
                    &nbsp;&nbsp;&nbsp;{{ $notificacion->created_at ? $notificacion->created_at->format('H:i') : '' }}
                </div>
            </div>
        </div>

        @if ($notificacion->archivo)
            <div class="p-3 border-bottom border-block-end-dashed">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="text-muted">1 archivo adjunto</div>
                    <div class="fw-semibold fs-16 text-dark"><i class="bi bi-cloud-download-fill"
                            style="font-size: 20px;"></i>
                    </div>
                </div>
            </div>
        @endif


        <div class="modal-footer">

            <button type="button" class="btn btn-primary rounded-pill  btn-wave" data-bs-toggle="modal"
                data-bs-target="#modal-responder">&nbsp;Responder&nbsp;</button>


        </div>
    </div>


</div>

<div class="modal fade" id="modal-responder" tabindex="-1" aria-labelledby="modalEditAbogadoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modalEditAbogadoLabel">Notificar</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

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
                                    <span class="me-1 d-inline-block">{{ $notificacion->user->name ?? '' }}  {{ $notificacion->user->lastname ?? '' }}</span>
                                </div>
                                <div class="mb-1">
                                    <span class="me-1 d-inline-block">{{ $notificacion->user->email ?? '' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12">
                        <label for="lastname" class="form-label">Redactar mensaje</label>
                        <textarea name="mensaje" class="form-control" required></textarea>
                    </div>

                    <div class="col-md-12">
                        <label for="lastname" class="form-label">Adjuntar documento</label>
                        <input type="file" name="archivo" class="form-control">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </div>

        </div>
    </div>
</div>

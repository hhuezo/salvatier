   <div class="modal fade" id="modal-confirmar-{{ $item->id }}" tabindex="-1" aria-labelledby="modalViewAsesoriaLabel"
       aria-hidden="true">
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
                           <input type="hidden" class="form-control" name="id" value="{{ $item->id }}"
                               readonly>
                           <div class="col-12">
                               <div class="d-flex align-items-center">
                                   <div class="me-3">
                                       <span class="avatar avatar-xl bg-primary-transparent">
                                           <img src="{{ $item->user->photo ? asset('storage/photos/' . $item->user->photo) : asset('assets/images/perfil.png') }}"
                                               alt="">
                                       </span>
                                   </div>
                                   <div>
                                       <div class="mb-1 fs-14 fw-medium">
                                           <a href="javascript:void(0);">
                                               Usuario</a>
                                       </div>
                                       <div class="mb-1">
                                           <span class="me-1 d-inline-block">{{ $item->user->name ?? '' }}
                                               {{ $item->user->lastname ?? '' }}</span>
                                       </div>
                                       <div class="mb-1">
                                           <span class="me-1 d-inline-block">{{ $item->user->email ?? '' }} </span>
                                       </div>
                                   </div>
                               </div>
                           </div>

                           <div class="col-12">
                               <label class="form-label fw-bold">Descripción:</label><br>
                               <span class="me-1 d-inline-block">{{ $item->descripcion }}</span>
                           </div>

                           <div class="col-md-12">
                               <label class="form-label fw-bold">Tipo asesoria:</label>
                               <input type="text" class="form-control" value="{{ $item->tipo->nombre ?? '' }}"
                                   readonly>
                           </div>

                           <div class="col-md-12">
                               <label class="form-label fw-bold">Modo asesoria:</label>
                               <input type="text" class="form-control" value="{{ $item->modo->nombre ?? '' }}"
                                   readonly>
                           </div>

                           <div class="col-md-12">
                               <label class="form-label fw-bold">Fecha asesoria:</label>
                               <input type="date" class="form-control" value="{{ $item->fecha ?? '' }}" readonly>
                           </div>
                           <div class="col-md-12">
                               <label class="form-label fw-bold">Hora asesoria:</label>
                               <input type="time" class="form-control" value="{{ $item->hora ?? '' }}" readonly>
                           </div>

                           <div class="col-md-12">
                               <label class="form-label fw-bold">Abogado asignado:</label>
                               <select class="form-select" name="abogado_asignado_id">
                                   @foreach ($abogados as $abogado)
                                       <option value="{{ $abogado->id }}"
                                           {{ $item->abogado_asignado_id == $abogado->id ? 'selected' : '' }}>
                                           {{ $abogado->name }}
                                           {{ $abogado->lastname }}</option>
                                   @endforeach
                               </select>
                           </div>
                           @if ($item->modo_asesoria_id == 2)
                               <div class="col-md-12">
                                   <label class="form-label fw-bold">Adjuntar enlace de asesoria:</label>
                                   <input type="text" class="form-control" name="enlace">
                               </div>
                           @endif

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

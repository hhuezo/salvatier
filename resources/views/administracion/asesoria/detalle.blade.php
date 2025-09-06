   <div class="card custom-card">
       <div class="card-header justify-content-between">
           <div class="card-title">
               Detalle
           </div>
       </div>

       <div class="card-body">

           <div class="row gy-3">
               <input type="hidden" class="form-control" id="asesoria_id" readonly>
               <div class="col-12">
                   <div class="d-flex align-items-center">
                       <div class="me-3">
                           <span class="avatar avatar-xl bg-primary-transparent">
                               <img src="{{ $asesoria->user->photo ? asset('storage/photos/' . $asesoria->user->photo) : asset('assets/images/perfil.png') }}"
                                   alt="">
                           </span>
                       </div>
                       <div>
                           <div class="mb-1 fs-14 fw-medium">
                               <a href="javascript:void(0);">
                                   Usuario</a>
                           </div>
                           <div class="mb-1">
                               <span class="me-1 d-inline-block">{{ $asesoria->user->name ?? '' }}
                                   {{ $asesoria->user->lastname ?? '' }}</span>
                           </div>
                           <div class="mb-1">
                               <span class="me-1 d-inline-block">{{ $asesoria->user->email ?? '' }} </span>
                           </div>
                       </div>
                   </div>
               </div>



               <!-- Descripción -->
               <div class="col-12">
                   <label class="form-label fw-bold">Descripción:</label>
                   <textarea class="form-control" rows="3" readonly>{{ $asesoria->descripcion }}</textarea>
               </div>

               <!-- Tipo -->
               <div class="col-md-12">
                   <label class="form-label fw-bold">Tipo asesoria:</label>
                   <input type="text" class="form-control" value="{{ $asesoria->tipo->nombre ?? '' }}" readonly>
               </div>



               <!-- Modo -->
               <div class="col-md-12">
                   <label class="form-label fw-bold">Modo asesoria:</label>
                   <input type="text" value="{{ $asesoria->modo->nombre ?? '' }}" class="form-control" readonly>
               </div>

               <!-- Fecha -->
               <div class="col-md-12">
                   <label class="form-label fw-bold">Fecha asesoria:</label>
                   <input type="date" class="form-control" value="{{ $asesoria->fecha ?? '' }}" readonly>
               </div>

               <!-- Hora -->
               <div class="col-md-12">
                   <label class="form-label fw-bold">Hora asesoria:</label>
                   <input type="time" class="form-control" value="{{ $asesoria->hora ?? '' }}" readonly>
               </div>

               @if ($asesoria->abogado_asignado)
                   <div class="col-md-12">
                       <label class="form-label fw-bold">Abogado asignado:</label>
                       <input type="text" class="form-control"
                           value="{{ $asesoria->abogado_asignado->name ?? '' }} {{ $asesoria->abogado_asignado->lastname ?? '' }}"
                           readonly>
                   </div>
               @endif


           </div>
       </div>

       <div class="modal-footer">
           @if ($asesoria->estado_asesoria_id == 2 || $asesoria->estado_asesoria_id == 3)
               <button type="button" class="btn btn-primary d-block w-100 rounded-pill  btn-wave"
                   data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#modal-reagendar">Reagendar</button>
           @endif
           @if ($asesoria->estado_asesoria_id == 1)
               <button type="button" class="btn btn-primary d-block w-100 rounded-pill btn-wave" data-bs-toggle="modal"
                   data-bs-target="#modal-confirmar">
                   Confirmar
               </button>
           @endif



       </div>


   </div>


   <div class="modal fade" id="modal-confirmar" tabindex="-1" aria-labelledby="modalViewAsesoriaLabel"
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
                           <input type="hidden" class="form-control" name="id" value="{{ $asesoria->id }}"
                               readonly>
                           <div class="col-12">
                               <div class="d-flex align-items-center">
                                   <div class="me-3">
                                       <span class="avatar avatar-xl bg-primary-transparent">
                                           <img src="{{ $asesoria->user->photo ? asset('storage/photos/' . $asesoria->user->photo) : asset('assets/images/perfil.png') }}"
                                               alt="">
                                       </span>
                                   </div>
                                   <div>
                                       <div class="mb-1 fs-14 fw-medium">
                                           <a href="javascript:void(0);">
                                               Usuario</a>
                                       </div>
                                       <div class="mb-1">
                                           <span class="me-1 d-inline-block">{{ $asesoria->user->name ?? '' }}
                                               {{ $asesoria->user->lastname ?? '' }}</span>
                                       </div>
                                       <div class="mb-1">
                                           <span class="me-1 d-inline-block">{{ $asesoria->user->email ?? '' }} </span>
                                       </div>
                                   </div>
                               </div>
                           </div>



                           <!-- Descripción -->
                           <div class="col-12">
                               <label class="form-label fw-bold">Descripción:</label><br>
                               <span class="me-1 d-inline-block">{{ $asesoria->descripcion }}</span>
                           </div>

                           <!-- Tipo -->
                           <div class="col-md-12">
                               <label class="form-label fw-bold">Tipo asesoria:</label>
                               <input type="text" class="form-control" value="{{ $asesoria->tipo->nombre ?? '' }}"
                                   readonly>
                           </div>



                           <!-- Modo -->
                           <div class="col-md-12">
                               <label class="form-label fw-bold">Modo asesoria:</label>
                               <input type="text" class="form-control"
                                   value="{{ $asesoria->modo->nombre ?? '' }}" readonly>
                           </div>

                           <!-- Fecha -->
                           <div class="col-md-12">
                               <label class="form-label fw-bold">Fecha asesoria:</label>
                               <input type="date" class="form-control" value="{{ $asesoria->fecha ?? '' }}"
                                   readonly>
                           </div>

                           <!-- Hora -->
                           <div class="col-md-12">
                               <label class="form-label fw-bold">Hora asesoria:</label>
                               <input type="time" class="form-control" value="{{ $asesoria->hora ?? '' }}"
                                   readonly>
                           </div>

                           <div class="col-md-12">
                               <label class="form-label fw-bold">Abogado asignado:</label>
                               <select class="form-select" name="abogado_asignado_id">
                                   @foreach ($abogados as $abogado)
                                       <option value="{{ $abogado->id }}"
                                           {{ $asesoria->abogado_asignado_id == $abogado->id ? 'selected' : '' }}>
                                           {{ $abogado->name }}
                                           {{ $abogado->lastname }}</option>
                                   @endforeach
                               </select>
                           </div>

                           <div class="col-md-12" id="divEnlace" style="display: none;">
                               <label class="form-label fw-bold">Adjuntar enlace de asesoria:</label>
                               <input type="text" class="form-control" name="enlace">
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
                                           <img src="{{ $asesoria->user->photo ? asset('storage/photos/' . $asesoria->user->photo) : asset('assets/images/perfil.png') }}"
                                               alt="">
                                       </span>
                                   </div>
                                   <div>
                                       <div class="mb-1 fs-14 fw-medium">
                                           <a href="javascript:void(0);">Usuario</a>
                                       </div>
                                       <div class="mb-1">
                                           <span class="me-1 d-inline-block">{{ $asesoria->user->name ?? '' }}
                                               {{ $asesoria->user->lastname ?? '' }}</span>
                                       </div>
                                       <div class="mb-1">
                                           <span class="me-1 d-inline-block">{{ $asesoria->user->email ?? '' }}
                                           </span>
                                       </div>
                                   </div>
                               </div>
                           </div>

                           <!-- Fecha -->
                           <div class="col-md-12">
                               <label class="form-label fw-bold">Fecha asesoria:</label>
                               <input type="hidden" name="id"
                                   value="{{ $asesoria->id }}" class="form-control" required>
                               <input type="date" name="fecha"  value="{{ $asesoria->fecha }}" class="form-control" required>
                               @error('fecha')
                                   <span class="text-danger small">{{ $message }}</span>
                               @enderror
                           </div>

                           <!-- Hora -->
                           <div class="col-md-12">
                               <label class="form-label fw-bold">Hora asesoria:</label>
                               <input type="time" name="hora" value="{{ $asesoria->hora }}" class="form-control" required>
                               @error('hora')
                                   <span class="text-danger small">{{ $message }}</span>
                               @enderror
                           </div>

                           <!-- Comentario -->
                           <div class="col-12">
                               <label class="form-label fw-bold">Comentario:</label>
                               <textarea class="form-control" name="comentario" rows="3">{{ old('comentario') }}</textarea>
                               @error('comentario')
                                   <span class="text-danger small">{{ $message }}</span>
                               @enderror
                           </div>

                       </div>
                   </div>

                   <div class="modal-footer">
                       <button type="button" class="btn btn-outline-secondary rounded-pill btn-wave"
                           data-bs-dismiss="modal">Cancelar</button>
                       <button type="submit" class="btn btn-primary rounded-pill btn-wave">
                           Reagendar
                       </button>
                   </div>
               </form>

           </div>
       </div>
   </div>

@extends('menu')
@section('content')

    <!-- Toastr CSS -->
    <link href="{{ asset('assets/libs/toast/toastr.min.css') }}" rel="stylesheet">

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>

    <!-- Toastr JS -->
    <script src="{{ asset('assets/libs/toast/toastr.min.js') }}"></script>



    @if (session('success'))
        <script>
            toastr.success("{{ session('success') }}");
        </script>
    @endif

    @if (session('error'))
        <script>
            toastr.error("{{ session('error') }}");
        </script>
    @endif


    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    Asesoria
                </div>
                <div class="prism-toggle">
                    <a href="{{ url('administracion/asesoria') }}">
                        <button class="btn btn-primary"><i class="bi bi-arrow-90deg-left"></i></button>
                    </a>
                </div>
            </div>
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div id="errorMessages"></div>


                <div class="modal-body">
                    <div class="row gy-3">

                        <div class="col-md-6">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" class="form-control" name="fecha" value="{{ $asesoria->fecha }}"
                                disabled>
                        </div>

                        <div class="col-md-6">
                            <label for="hora" class="form-label">Hora</label>
                            <input type="time" class="form-control" name="hora" value="{{ $asesoria->hora }}"
                                disabled>
                        </div>

                        <div class="col-md-6">
                            <label for="tipo_asesoria_id" class="form-label">Tipo de asesoria</label>

                            <input type="text" class="form-control" value="{{ $asesoria->tipo->nombre }}" disabled>
                        </div>

                        <div class="col-md-6">
                            <label for="modo_asesoria_id" class="form-label">Seleccione el modo en que quiere realizar
                                su asesoria</label>
                            <input type="text" class="form-control" value="{{ $asesoria->modo->nombre }}" disabled>
                        </div>

                        <div class="col-md-12">
                            <label for="descripcion" class="form-label">Descripcion (opcional)</label>
                            <textarea class="form-control" name="descripcion" rows="3" disabled>{{ $asesoria->descripcion }}</textarea>
                        </div>

                    </div>

                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Notificaciones
                        </div>
                        <div class="prism-toggle">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-create"><i
                                    class="bi bi-plus-circle"></i></button>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Mensaje</th>
                                <th scope="col">Archivo</th>
                                <th scope="col">Leído</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($asesoria->notificaciones as $pago)
                                <tr class="{{ $pago->finalizado ? 'table-success' : '' }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pago->fecha ? \Carbon\Carbon::parse($pago->fecha)->format('d/m/Y') : '-' }}
                                    </td>
                                    <td>{{ $pago->mensaje }}</td>
                                    <td>
                                        @if ($pago->archivo)
                                            <a href="{{ asset('storage/notificaciones/' . $pago->archivo) }}"
                                                target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-paperclip"></i> Ver archivo
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td>
                                        @if ($pago->leido)
                                            <span class="badge bg-success">Leído</span>
                                        @else
                                            <span class="badge bg-secondary">No leído</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>






            </div>
        </div>
    </div>



    <div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="modalCreatePagoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modalCreatePagoLabel">Notificar</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <form method="POST" action="{{ route('notificacion.store') }}" id="form"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="form-control" name="asesoria_id" id="asesoria_id"
                        value="{{ $asesoria->id }}">
                    <div class="modal-body">

                        <div id="error-container" style="display:none;" class="alert alert-danger">
                            <ul id="error-list" class="mb-0"></ul>
                        </div>

                        <div class="row gy-3">
                            <div class="col-md-12">
                                <label class="form-label" for="mensaje">Redactar mensaje</label>
                                <textarea name="mensaje" id="mensaje" class="form-control">{{ old('mensaje', $asesoria->mensaje ?? '') }}</textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label" for="archivo">Archivo</label>
                                <input type="file" class="form-control" name="archivo" id="archivo"
                                    accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip">
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" id="btnEnviar" class="btn btn-primary" onclick="validarNotificacion()">
                            <span id="btn-text">Enviar</span>
                            <span id="btn-spinner" class="spinner-border spinner-border-sm" role="status"
                                aria-hidden="true" style="display: none;"></span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            expandMenuAndHighlightOption('li-pago');
        });



        function validarNotificacion() {
            // Limpiar errores previos
            const errorContainer = document.getElementById('error-container');
            const errorList = document.getElementById('error-list');
            if (errorList) errorList.innerHTML = '';
            if (errorContainer) errorContainer.style.display = 'none';

            const asesoriaId = document.getElementById('asesoria_id')?.value.trim();
            const mensaje = document.getElementById('mensaje')?.value.trim();
            const archivoInput = document.getElementById('archivo');
            const errores = [];

            // Validaciones
            if (!asesoriaId) {
                errores.push('El campo Asesoría es obligatorio.');
            }

            if (!mensaje) {
                errores.push('Debe redactar un mensaje antes de enviar la notificación.');
            } else if (mensaje.length > 500) {
                errores.push('El mensaje no puede superar los 500 caracteres.');
            }

            if (archivoInput?.files.length > 0) {
                const archivo = archivoInput.files[0];
                const tiposPermitidos = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'zip'];
                const extension = archivo.name.split('.').pop().toLowerCase();

                if (!tiposPermitidos.includes(extension)) {
                    errores.push('El archivo debe ser PDF, DOC, DOCX, JPG, JPEG, PNG o ZIP.');
                }

                const maxSize = 2 * 1024 * 1024; // 2MB
                if (archivo.size > maxSize) {
                    errores.push('El archivo no puede superar los 2MB.');
                }
            }

            // Mostrar errores si los hay
            if (errores.length > 0) {
                errores.forEach(e => {
                    const li = document.createElement('li');
                    li.textContent = e;
                    errorList.appendChild(li);
                });
                errorContainer.style.display = 'block';
                return;
            }

            // Mostrar loading
            const btn = document.getElementById('btnEnviar');
            const btnText = document.getElementById('btn-text');
            const btnSpinner = document.getElementById('btn-spinner');

            if (btn) btn.disabled = true;
            if (btnText) btnText.style.display = 'none';
            if (btnSpinner) btnSpinner.style.display = 'inline-block';

            // Enviar formulario
            document.getElementById('form').submit();
        }
    </script>
@endsection

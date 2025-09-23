@extends ('menu')
@section('content')
    <!-- Toastr CSS -->
    <link href="{{ asset('assets/libs/toast/toastr.min.css') }}" rel="stylesheet">

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>

    <!-- Toastr JS -->
    <script src="{{ asset('assets/libs/toast/toastr.min.js') }}"></script>

    <link href="{{ asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" />

    <!-- JS de Select2 -->
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>

    <style>
        .select2-container--default .select2-selection--single {
            height: 38px;
            padding: 5px;
            border: 1px solid #ced4da;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 26px;
        }
    </style>

    <!-- Inputmask -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.9/jquery.inputmask.min.js"></script>


    <div class="row">
        <div class="col-xl-8">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Tarjeta de débito a crédito
                    </div>
                </div>
                <form method="POST" action="{{ url('usuario/asesoria/pago') }}" id="formPago">
                    @csrf

                    <div class="card-body">
                        <p style="margin-top: -27px;">Complete los campos solicitados para realizar el pago</p>

                        <div class="row gy-3">
                            <div class="col-md-12">
                                <label class="form-label">País</label>
                                <select name="pais" id="pais" class="form-select select2">
                                    <option value="">Seleccione</option>
                                    @foreach ($regiones as $region)
                                        <option value="{{ $region['id'] }}">{{ $region['nombre'] }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger" id="errorPais"></small>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Territorio</label>
                                <select name="territorio" id="territorio" class="form-select select2">
                                    <option value="">Seleccione</option>
                                </select>
                                <small class="text-danger" id="errorTerritorio"></small>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Número de tarjeta</label>
                                <input type="text" id="numero_tarjeta" name="numero_tarjeta" class="form-control"
                                    required>
                                <small class="text-danger" id="errorTarjeta"></small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Fecha de expiración</label>
                                <input type="text" id="fecha_expedicion" name="fecha_expedicion" class="form-control"
                                    required>
                                <small class="text-danger" id="errorFecha"></small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">CVV</label>
                                <input type="password" id="cvv" name="cvv" class="form-control" required>
                                <small class="text-danger" id="errorCVV"></small>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Tarjetas aceptadas</label>
                            </div>
                            <div class="col-md-12">
                                <img src="{{ asset('assets/images/logo_tarjetas.png') }}" style="max-width:150px">
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Realizar pago
                    </div>
                </div>
                <div class="card-body" style="text-align: center">
                    <div class="alert alert-success rounded-pill d-flex justify-content-between">
                        <span><strong>Precio a cancelar</strong></span>
                        <strong>${{ $configuracion->costo_asesoria }}</strong>
                    </div>

                    <!-- Vista previa con la imagen de la tarjeta -->
                    <div style="text-align: center; position: relative; display: inline-block;">
                        <!-- Imagen de la tarjeta -->

                        <img src="{{ asset('assets/images/tarjeta_credito.jpg') }}" style="max-width:330px;">


                        <!-- Número de tarjeta -->
                        <div id="card_number"
                            style="position: absolute; top: 85px; left: 90px;
                            font-size: 15px; letter-spacing: 3px; color: white; font-weight: bold; white-space: nowrap;">
                        </div>


                        <!-- Fecha de expiración -->
                        <div id="card_exp"
                            style="position: absolute; bottom: 55px; left: 50px; font-size: 16px; color: white;">
                        </div>

                        <!-- CVV -->
                        <div id="card_cvv"
                            style="position: absolute; bottom: 50px; right: 120px; font-size: 16px; color: white;">
                        </div>
                    </div>



                </div>

                <div class="card-footer">
                    <button type="button" id="btnPagar" class="btn btn-primary rounded-pill btn-wav w-100 mt-2"
                        onclick="enviarFormulario()">
                        Realizar pago
                    </button>

                    <button class="btn btn-outline-primary rounded-pill btn-wav w-100 mt-2">Cancelar</button>
                </div>

            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            expandMenuAndHighlightOption('li-asesoria');
            // Aplicar máscaras sin placeholders
            $("#numero_tarjeta").inputmask("9999 9999 9999 9999", {
                placeholder: ""
            });
            $("#fecha_expedicion").inputmask("99/99", {
                placeholder: ""
            }); // MM/AA
            $("#cvv").inputmask("999", {
                placeholder: ""
            });

            // Reflejar número tarjeta
            $("#numero_tarjeta").on("input", function() {
                $("#card_number").text($(this).val());
            });

            // Reflejar fecha
            $("#fecha_expedicion").on("input", function() {
                $("#card_exp").text($(this).val());
            });

            // Reflejar CVV con asteriscos
            $("#cvv").on("input", function() {
                let cvvLength = $(this).val().length;
                $("#card_cvv").text("*".repeat(cvvLength));
            });

            $('.select2').select2({
                //placeholder: "Seleccione",
                allowClear: true,
                width: '100%'
            });

            $("#pais").on("change", function() {
                let paisId = $(this).val();
                let $territorio = $("#territorio");

                // Limpiar select territorio y poner opción de carga
                $territorio.empty().append('<option value="">Cargando...</option>');
                $territorio.trigger('change.select2');

                if (paisId) {
                    $.ajax({
                        url: "{{ url('usuario/asesoria/get_territorio') }}/" + paisId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            // Limpiar y agregar opción inicial
                            $territorio.empty().append(
                                '<option value="">Seleccione un territorio</option>');

                            // Agregar cada territorio
                            $.each(data, function(index, territorio) {
                                $territorio.append('<option value="' + territorio.id +
                                    '">' + territorio.nombre + '</option>');
                            });

                            // Refrescar Select2 para que muestre las nuevas opciones
                            $territorio.trigger('change.select2');
                        },
                        error: function() {
                            $territorio.empty().append(
                                '<option value="">Error al cargar</option>');
                            $territorio.trigger('change.select2');
                        }
                    });
                } else {
                    $territorio.empty().append('<option value="">Seleccione un territorio</option>');
                    $territorio.trigger('change.select2');
                }
            });



        });

        function enviarFormulario() {
            const btn = document.getElementById('btnPagar');

            // Bloquear botón mientras se valida
            btn.disabled = true;

            // Limpiar errores previos
            ['errorPais', 'errorTerritorio', 'errorTarjeta', 'errorFecha', 'errorCVV'].forEach(id => {
                document.getElementById(id).textContent = '';
            });

            const pais = document.getElementById('pais').value;
            const territorio = document.getElementById('territorio').value;
            const numeroTarjeta = document.getElementById('numero_tarjeta').value.trim();
            const fechaExp = document.getElementById('fecha_expedicion').value.trim();
            const cvv = document.getElementById('cvv').value.trim();

            let error = false;

            if (!pais) {
                document.getElementById('errorPais').textContent = 'Seleccione un país.';
                error = true;
            }

            if (!territorio) {
                document.getElementById('errorTerritorio').textContent = 'Seleccione un territorio.';
                error = true;
            }

            if (!/^\d{13,19}$/.test(numeroTarjeta)) {
                document.getElementById('errorTarjeta').textContent = 'Número de tarjeta inválido (13-19 dígitos).';
                error = true;
            }

            if (!/^(0[1-9]|1[0-2])\/\d{4}$/.test(fechaExp)) {
                document.getElementById('errorFecha').textContent = 'Formato fecha inválido (MM/AAAA).';
                error = true;
            }

            if (!/^\d{3,4}$/.test(cvv)) {
                document.getElementById('errorCVV').textContent = 'CVV inválido (3-4 dígitos).';
                error = true;
            }

            if (!error) {
                // Todo correcto, enviar formulario
                document.getElementById('formPago').submit();
            } else {
                // Si hay error, desbloquear botón para corregir
                btn.disabled = false;
            }
        }
    </script>
@endsection

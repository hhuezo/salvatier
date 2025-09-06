@extends ('menu')
@section('content')
    <!-- Toastr CSS -->
    <link href="{{ asset('assets/libs/toast/toastr.min.css') }}" rel="stylesheet">

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>

    <!-- Toastr JS -->
    <script src="{{ asset('assets/libs/toast/toastr.min.js') }}"></script>

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
                <div class="card-body">
                    <p style="margin-top: -27px;">Complete los campos solicitados para realizar el pago</p>

                    <div class="row gy-3">
                        <div class="col-md-12">
                            <label class="form-label">Número de tarjeta</label>
                            <input type="text" id="numero_tarjeta" name="numero_tarjeta" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Fecha de expiración</label>
                            <input type="text" id="fecha_expedicion" name="fecha_expedicion" class="form-control"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">CVV</label>
                            <input type="password" id="cvv" name="cvv" class="form-control" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Tarjetas aceptadas</label>
                        </div>
                        <div class="col-md-12">
                            <img src="{{ asset('assets/images/logo_tarjetas.png') }}" style="max-width:150px">
                        </div>

                    </div>
                </div>
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
                        <span>Precio a cancelar</span>
                        <strong>$150.00</strong>
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
                    <button class="btn btn-primary rounded-pill btn-wav w-100 mt-2">Realizar pago</button>
                     <button class="btn btn-outline-primary rounded-pill btn-wav w-100 mt-2">Cancelar</button>
                </div>

            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
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

            // Reflejar CVV
            // Reflejar CVV con asteriscos
            $("#cvv").on("input", function() {
                let cvvLength = $(this).val().length;
                $("#card_cvv").text("*".repeat(cvvLength));
            });

        });
    </script>
@endsection

@extends ('menu')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-10 bg-white dark bg-dark text-dark rounded shadow border p-4">

                <div class="text-center mb-4">
                    <span class="material-symbols-outlined display-1 text-success">
                        check_circle
                    </span>
                    <h2 class="mt-3 fw-bold">¡Pago exitoso!</h2>
                    <p class="text-muted">Tu pago ha sido procesado con éxito. Recibirás un correo electrónico de
                        confirmación en breve.</p>
                </div>

                <div class="bg-light dark p-4 rounded mb-4">
                    <div style="text-align: center">
                    <h3 class="h5 fw-medium mb-3">Detalles del pago</h3></div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span class="text-muted">Monto</span>
                        <span class="fw-semibold">$125.00</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span class="text-muted">Fecha</span>
                        <span class="fw-semibold">15 de octubre de 2024</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span class="text-muted">Método de pago</span>
                        <span class="fw-semibold">Tarjeta de crédito</span>
                    </div>
                    <div class="d-flex justify-content-between pt-2">
                        <span class="text-muted">ID de transacción</span>
                        <span class="fw-semibold">TXN1234567890</span>
                    </div>
                </div>

                <div class="d-grid gap-2 d-sm-flex justify-content-sm-between">
                    <button class="btn btn-primary flex-fill">Volver al inicio</button>
                    {{-- <button class="btn btn-outline-secondary flex-fill">Ver historial de pedidos</button> --}}
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection

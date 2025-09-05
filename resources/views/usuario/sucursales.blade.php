@extends ('menu')
@section('content')
    <div class="col-xl-12"
        style="background-image: url('{{ asset('assets/images/inicio_cliente.jpg') }}');
           background-size: cover;
           background-position: top;  /* desde arriba */
           background-repeat: no-repeat;
           height: 400px;">
    </div>
    <br>
    <div class="row" style="margin-top: -150px !important; padding: 20px !important">
        {{-- <div class="col-md-12 col-xxl-12">
            <div class="card border border-primary border-opacity-25 custom-card" style="z-index: 1;">

                <div class="alert alert-success" role="alert">
                    Sucursales
                </div>
            </div>
        </div> --}}

        <div class="col-xxl col-xl-6">
            <div class="card custom-card border border-primary border-opacity-25">
                <div class="card-header justify-content-between bg-success-subtle">
                    <div class="card-title">
                        <h4 class="mb-1">San Miguel</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-3 align-items-center">
                        <div class="flex-fill">

                            <p class="text-muted fw-medium mb-2"><strong>Direccion:</strong> Opera/8.69 (X11; Linux i686;
                                sl-SI) Presto/2.10.204 Version/12.00</p>

                            <p class="text-muted fw-medium mb-2"><strong>Telefonos:</strong> 12305-6529 12305-6529</p>

                            <p class="text-muted fw-medium mb-2"><strong>Horarios:</strong> Lunes a Viernes de 08:00 AM a
                                4:00 PM, Sabados de 08:00 AM a 12:00 PM</p>

                            <p class="text-muted fw-medium mb-2"><strong>Servicios:</strong>
                                Lorem ipsum
                                Lorem ipsum
                                Lorem ipsum
                                Lorem ipsum
                            </p>
                        </div>
                        <span
                            class="avatar avatar-lg bg-primary-transparent svg-primary avatar-rounded border-3 border border-opacity-50 flex-shrink-0 border-primary">

                            <i class="bi bi-houses"></i>

                        </span>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xxl col-xl-6">
            <div class="card custom-card border border-primary border-opacity-25">
                <div class="card-header justify-content-between bg-success-subtle">
                    <div class="card-title">
                        <h4 class="mb-1">Santa Ana</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-3 align-items-center">
                        <div class="flex-fill">

                            <p class="text-muted fw-medium mb-2"><strong>Direccion:</strong> Opera/8.69 (X11; Linux i686;
                                sl-SI) Presto/2.10.204 Version/12.00</p>

                            <p class="text-muted fw-medium mb-2"><strong>Telefonos:</strong> 12305-6529 12305-6529</p>

                            <p class="text-muted fw-medium mb-2"><strong>Horarios:</strong> Lunes a Viernes de 08:00 AM a
                                4:00 PM, Sabados de 08:00 AM a 12:00 PM</p>

                            <p class="text-muted fw-medium mb-2"><strong>Servicios:</strong>
                                Lorem ipsum
                                Lorem ipsum
                                Lorem ipsum
                                Lorem ipsum
                            </p>
                        </div>
                        <span
                            class="avatar avatar-lg bg-primary-transparent svg-primary avatar-rounded border-3 border border-opacity-50 flex-shrink-0 border-primary">

                            <i class="bi bi-houses"></i>

                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl col-xl-6">
            <div class="card custom-card border border-primary border-opacity-25">
                <div class="card-header justify-content-between bg-success-subtle">
                    <div class="card-title">
                        <h4 class="mb-1">San Salvador</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-3 align-items-center">
                        <div class="flex-fill">

                            <p class="text-muted fw-medium mb-2"><strong>Direccion:</strong> Opera/8.69 (X11; Linux i686;
                                sl-SI) Presto/2.10.204 Version/12.00</p>

                            <p class="text-muted fw-medium mb-2"><strong>Telefonos:</strong> 12305-6529 12305-6529</p>

                            <p class="text-muted fw-medium mb-2"><strong>Horarios:</strong> Lunes a Viernes de 08:00 AM a
                                4:00 PM, Sabados de 08:00 AM a 12:00 PM</p>

                            <p class="text-muted fw-medium mb-2"><strong>Servicios:</strong>
                                Lorem ipsum
                                Lorem ipsum
                                Lorem ipsum
                                Lorem ipsum
                            </p>
                        </div>
                        <span
                            class="avatar avatar-lg bg-primary-transparent svg-primary avatar-rounded border-3 border border-opacity-50 flex-shrink-0 border-primary">

                            <i class="bi bi-houses"></i>

                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

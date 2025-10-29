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

        @foreach ($oficinas as $oficina)
            <div class="col-xxl col-xl-6">
                <div class="card custom-card border border-primary border-opacity-25">
                    <div class="card-header justify-content-between bg-success-subtle">
                        <div class="card-title">
                            <h4 class="mb-1">{{$oficina->nombre}}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-3 align-items-center">
                            <div class="flex-fill">

                                <p class="text-muted fw-medium mb-2"><strong>Direccion:</strong> {{$oficina->direccion}}</p>

                                <p class="text-muted fw-medium mb-2"><strong>Telefonos:</strong> {{$oficina->telefono}}</p>

                                <p class="text-muted fw-medium mb-2"><strong>Horarios:</strong> Lunes a Viernes de 08:00 AM
                                    a
                                    4:00 PM, Sabados de 08:00 AM a 12:00 PM</p>
                            </div>
                            <span
                                class="avatar avatar-lg bg-primary-transparent svg-primary avatar-rounded border-3 border border-opacity-50 flex-shrink-0 border-primary">

                                <i class="bi bi-houses"></i>

                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach


    </div>
@endsection

@extends('menu')
@section('content')
    @can('dashboard')
        <!-- Highcharts -->
        <script src="https://code.highcharts.com/highcharts.js"></script>

        <style>
            .highcharts-credits {
                display: none;
            }
        </style>

        <div class="row">
            <!-- Gráfico de Barras -->
            <div class="col-12 col-md-12 col-sm-12 mb-4">
                <div class="card custom-card">
                    <div class="card-body">
                        <div id="grafico-pagos" style="height: 300px;"></div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-6 col-sm-12 mb-4">
                <div class="card custom-card">
                    <div class="card-body">
                        <div id="grafico-pagos-pendientes" style="height: 300px;"></div>
                    </div>
                </div>
            </div>

        </div>


        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Highcharts.chart('grafico-pagos', {
                    chart: {
                        type: 'column',
                        backgroundColor: null
                    },
                    title: {
                        text: 'Pagos por Mes',
                        style: {
                            color: '#000'
                        }
                    },
                    xAxis: {
                        categories: @json($labelsFinalizados),
                        labels: {
                            style: {
                                color: '#000'
                            }
                        }
                    },
                    yAxis: {
                        title: {
                            text: 'Cantidad',
                            style: {
                                color: '#000'
                            }
                        },
                        labels: {
                            style: {
                                color: '#000'
                            }
                        }
                    },
                    plotOptions: {
                        column: {
                            colorByPoint: true, // Cada barra con diferente color
                            dataLabels: {
                                enabled: true, // Mostrar los valores
                                style: {
                                    fontWeight: 'bold',
                                    color: '#000'
                                },
                                formatter: function() {
                                    return '$' + Highcharts.numberFormat(this.y, 2, '.', ',');
                                }
                            }
                        }
                    },
                    series: [{
                        name: 'Pagos',
                        data: @json($dataFinalizados),
                        colors: [
                            '#00B681', '#004C33', '#FF5733', '#FFC300', '#C70039',
                            '#900C3F', '#581845', '#2E86C1', '#117A65', '#F39C12',
                            '#8E44AD', '#1ABC9C'
                        ]
                    }],
                    legend: {
                        enabled: false
                    }
                });

                Highcharts.chart('grafico-pagos-pendientes', {
                    chart: {
                        type: 'column',
                        backgroundColor: null
                    },
                    title: {
                        text: 'Pagos pendientes',
                        style: {
                            color: '#000'
                        }
                    },
                    xAxis: {
                        categories: @json($labelsPendientes),
                        labels: {
                            style: {
                                color: '#000'
                            }
                        }
                    },
                    yAxis: {
                        title: {
                            text: 'Cantidad',
                            style: {
                                color: '#000'
                            }
                        },
                        labels: {
                            style: {
                                color: '#000'
                            }
                        }
                    },
                    plotOptions: {
                        column: {
                            colorByPoint: true, // Cada barra con diferente color
                            dataLabels: {
                                enabled: true, // Mostrar los valores
                                style: {
                                    fontWeight: 'bold',
                                    color: '#000'
                                },
                                formatter: function() {
                                    return '$' + Highcharts.numberFormat(this.y, 2, '.', ',');
                                }
                            }
                        }
                    },
                    series: [{
                        name: 'Pagos',
                        data: @json($dataPendientes),
                        colors: [
                            '#00B681', '#004C33', '#FF5733', '#FFC300', '#C70039',
                            '#900C3F', '#581845', '#2E86C1', '#117A65', '#F39C12',
                            '#8E44AD', '#1ABC9C'
                        ]
                    }],
                    legend: {
                        enabled: false
                    }
                });
            });
        </script>
    @endcan

    @can('inicio cliente')
        <div class="col-xl-12"
            style="background-image: url('{{ asset('assets/images/inicio_cliente.jpg') }}');
           background-size: cover;
           background-position: top;  /* desde arriba */
           background-repeat: no-repeat;
           height: 450px;">
        </div>

        <div class="row" style="margin-top: -100px;">
            <div class="col-md-12 col-xxl-1"></div>

            <div class="col-md-12 col-xxl-4">

                <div class="card custom-card">
                    <img src="{{ asset('assets/images/proximas_asesorias.jpg') }}" class="card-img-top" alt="..."
                        style="height: 180px; object-fit: cover; object-position: center;">

                    <div class="card-body">
                        <h6 class="card-title fw-medium">Próximas asesorías agendadas</h6>
                        <p class="card-text text-muted">
                            As the wind whistled through the dense foliage, scattering leaves like
                            whispered secrets, a lone sapling stood resilient, its roots anchored deep in the earth.
                        </p>

                        <div class="card-footer text-end">
                            <a href="{{ url('usuario/asesoria/agendadas') }}">
                                <button class="btn btn-primary">Ver <i class="bi bi-arrow-right"></i></button>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-12 col-xxl-2"></div>

            <div class="col-md-12 col-xxl-4">

                <div class="card custom-card">
                    <img src="{{ asset('assets/images/notificaciones_importante.jpg') }}" class="card-img-top" alt="..."
                        style="height: 180px; object-fit: cover; object-position: center;">

                    <div class="card-body">
                        <h6 class="card-title fw-medium">Notificaciones importantes</h6>
                        <p class="card-text text-muted">
                            As the wind whistled through the dense foliage, scattering leaves like
                            whispered secrets, a lone sapling stood resilient, its roots anchored deep in the earth.
                        </p>

                        <div class="card-footer text-end">
                            <a href="{{ route('mis_notificaiones') }}" class="btn btn-primary">Ver <i
                                    class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

            </div>



            <div class="col-md-12 col-xxl-1"></div>
        </div>
    @endcan
@endsection

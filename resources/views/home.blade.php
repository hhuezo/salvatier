@extends('menu')
@section('content')
    <!-- Highcharts -->
    <script src="https://code.highcharts.com/highcharts.js"></script>

    <style>
        .highcharts-credits {
            display: none;
        }
    </style>

    <div class="row">
        <!-- Gráfico de Barras -->
        <div class="col-12 col-md-6 mb-4">
            <div class="card custom-card">
                <div class="card-body">
                    <div id="grafico-barras" style="height: 400px;"></div>
                </div>
            </div>
        </div>

        <!-- Gráfico de Pastel -->
        <div class="col-12 col-md-6 mb-4">
            <div class="card custom-card">
                <div class="card-body">
                    <div id="grafico-lineas" style="height: 400px;"></div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Gráfico de Barras Comparativo por Años
            Highcharts.chart('grafico-barras', {
                chart: {
                    type: 'column',
                    backgroundColor: null
                },
                title: {
                    text: 'Ventas por Año',
                    style: {
                        color: '#000'
                    }
                },
                xAxis: {
                    categories: ['2020', '2021', '2022', '2023', '2024', '2025'],
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
                legend: {
                    itemStyle: {
                        color: '#000'
                    }
                },
                series: [{
                        name: 'Ventas A',
                        data: [120, 150, 180, 200, 220, 250],
                        color: '#00B681'
                    },
                    {
                        name: 'Ventas B',
                        data: [100, 130, 160, 180, 210, 240],
                        color: '#004C33'
                    }
                ]
            });



            // Gráfico de Líneas Comparativo por Año
            Highcharts.chart('grafico-lineas', {
                chart: {
                    type: 'line',
                    backgroundColor: null
                },
                title: {
                    text: 'Ventas por Año (Líneas)',
                    style: {
                        color: '#000'
                    }
                },
                xAxis: {
                    categories: ['2020', '2021', '2022', '2023', '2024', '2025'],
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
                legend: {
                    itemStyle: {
                        color: '#000'
                    }
                },
                series: [{
                        name: '2024',
                        data: [120, 150, 180, 200, 220, 250],
                        color: '#00B681'
                    },
                    {
                        name: '2025',
                        data: [100, 130, 160, 180, 210, 240],
                        color: '#004C33'
                    }
                ]
            });

        });
    </script>
@endsection

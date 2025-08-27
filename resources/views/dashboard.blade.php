@extends('components.app')

@section('content')
    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>Dashboard</h1>
                </div>
            </div>
        </div>
        {{-- <div class="col-sm-8">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <button class="btn btn-primary">PDV</button>
                    </ol>
                </div>
            </div>
        </div> --}}
    </div>


    <div class="content mt-3">
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="p-0 clearfix">
                    <i class="fa fa-money bg-success p-4 font-2xl mr-3 float-left text-light"></i>
                    <div class="h5 mb-0 pt-3">R$ {{ number_format($valorEmVendaHoje, 2, ',', '.') }}</div>
                    <div class="text-uppercase font-weight-bold font-xs small">Total em Vendas (Hoje)</div>
                </div>
            </div>
        </div>

        {{-- <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="p-0 clearfix">
                    <i class="fa fa-money bg-danger p-4 font-2xl mr-3 float-left text-light"></i>
                    <div class="h5 mb-0 pt-3">39</div>
                    <div class="text-uppercase font-weight-bold font-xs small">Boletos Vencidos</div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="p-0 clearfix">
                    <i class="fa fa-money bg-warning p-4 font-2xl mr-3 float-left text-light"></i>
                    <div class="h5 mb-0 pt-3">3</div>
                    <div class="text-uppercase font-weight-bold font-xs small">Boletos a Vencer</div>
                </div>
            </div>
        </div> --}}
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-4">Total de vendas por mês</h4>
                <div id="chart">
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3">Vendas por Categoria </h4>
                <div id="chart-pie">
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@push('scripts')
    <script>
        var options = {
            chart: {
                type: 'bar'
            },
            series: [{
                data: [

                    @foreach ($valorVendasPorMes as $venda)
                        {
                            x: "{{ getMes($venda->mes) }}",
                            y: {{ $venda->valorTotalVendaMes }}
                        },
                    @endforeach
                ]
            }],
            yaxis: {
                labels: {
                    formatter: (val) => val.toLocaleString('pt-BR', {
                        style: 'currency',
                        currency: 'BRL'
                    })
                }
            },
            tooltip: {
                y: {
                    formatter: (val) => val.toLocaleString('pt-BR', {
                        style: 'currency',
                        currency: 'BRL'
                    })
                }
            },
            dataLabels: {
                enabled: true,
                formatter: (val) => val.toLocaleString('pt-BR', {
                    style: 'currency',
                    currency: 'BRL'
                })
            }
        }

        var chart = new ApexCharts(document.querySelector("#chart"), options);

        chart.render();
    </script>
@endpush

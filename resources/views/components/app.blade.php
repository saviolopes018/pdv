<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Gestão - PDV</title>
    <meta name="description" content="Clinicas">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/flag-icon.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/cs-skin-elastic.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/buttons.bootstrap4.min.css') }}">
    <script src="https://kit.fontawesome.com/66c16fc52c.js" crossorigin="anonymous"></script>


    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/chosen.min.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    @stack('styles')
</head>

<body>
    <!-- Left Panel -->

    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu"
                    aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="{{ route('dashboard') }}"><img src="{{ asset('assets/img/ciro-gestao.svg') }}"/></a>
                <a class="navbar-brand hidden" href="{{ route('dashboard') }}"><img src="{{ asset('assets/img/ciro-gestao.svg') }}"/></a>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}"> <i class="menu-icon fa fa-dashboard"></i>Dashboard </a>
                    </li>
                    {{-- <li class="{{ request()->routeIs('usuario.listagem') ? 'active' : '' }}">
                        <a href="{{ route('usuario.listagem') }}"> <i class="menu-icon fa fa-users"></i>Usuários </a>
                    </li> --}}
                    <li
                        class="{{ request()->routeIs('clientes.listagem') || request()->routeIs('clientes.cadastro') ? 'active' : '' }}">
                        <a href="{{ route('clientes.listagem') }}"> <i class="menu-icon fa fa-users"></i>Clientes</a>
                    </li>
                    {{-- <li class="menu-item-has-children dropdown active">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"> <i class="menu-icon fa fa-dollar"></i>Financeiro</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-pencil"></i><a href="{{ route('financeiro.lancamento.listagem') }}"></a></li>
                            <li><i class="fa fa-bank"></i><a href="#">Contas Bancárias</a></li>
                        </ul>
                    </li> --}}
                    <li
                        class="{{ request()->routeIs('financeiro.listagem') || request()->routeIs('financeiro.registrar') ? 'active' : '' }}">
                        <a href="{{ route('financeiro.listagem') }}"> <i
                                class="menu-icon fa fa-money-bill-1-wave"></i>Financeiro</a>
                    </li>
                    <li
                        class="{{ request()->routeIs('categoria.listagem') || request()->routeIs('categoria.adicionar') ? 'active' : '' }}">
                        <a href="{{ route('categoria.listagem') }}"> <i class="menu-icon fa fa-list"></i>Categorias</a>
                    </li>
                    <li
                        class="{{ request()->routeIs('produto.listagem') || request()->routeIs('produto.adicionar') ? 'active' : '' }}">
                        <a href="{{ route('produto.listagem') }}"> <i class="menu-icon fa fa-dolly"></i>Produtos</a>
                    </li>
                    <li
                        class="{{ request()->routeIs('estoque.listagem') || request()->routeIs('estoque.registrar') ? 'active' : '' }}">
                        <a href="{{ route('estoque.listagem') }}"> <i
                                class="menu-icon fa fa-right-left"></i>Estoque</a>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <header id="header" class="header">

            <div class="header-menu">

                <div class="col-sm-7">

                    <div class="header-left">
                        <a id="menuToggle" class="menutoggle pull-right"><i class="fa fa-bars"></i></a>
                        {{-- <div class="dropdown for-notification">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="notification"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-bell"></i>
                                <span class="count bg-danger"></span>
                            </button>
                        </div> --}}
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="user-area dropdown pull-right">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <img class="user-avatar rounded-circle" src="{{ asset('assets/img/avatar.png') }}"
                                alt="User Avatar">
                        </a>

                        <div class="user-menu dropdown-menu">
                            <a class="nav-link" href="#"><i class="fa fa-user"></i> Minha conta</a>

                            <a class="nav-link" href="{{ route('pdv') }}"><i class="fa-solid fa-right-to-bracket"></i> PDV</a>

                            {{-- <a class="nav-link" href="#"><i class="fa fa-cog"></i> Configurações</a> --}}

                            <a class="nav-link" href="{{ route('logout') }}"><i class="fa fa-power-off"></i>
                                Sair</a>
                        </div>
                    </div>

                    <div class="language-select dropdown" id="language-select">
                        <a class="dropdown-toggle" href="#" data-toggle="dropdown" id="language"
                            aria-haspopup="true" aria-expanded="true">
                            <i class="flag-icon flag-icon-us"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="language">
                            <div class="dropdown-item">
                                <span class="flag-icon flag-icon-fr"></span>
                            </div>
                            <div class="dropdown-item">
                                <i class="flag-icon flag-icon-es"></i>
                            </div>
                            <div class="dropdown-item">
                                <i class="flag-icon flag-icon-us"></i>
                            </div>
                            <div class="dropdown-item">
                                <i class="flag-icon flag-icon-it"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </header>

        @yield('content')
    </div>


    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        var options = {
            series: [44, 55, 13, 43, 22, 39],
            chart: {
                width: 380,
                type: 'pie',
            },
            labels: ['Marketing', 'Financeiro', 'Expedição', 'Administrativo', 'Manutenção', 'Comercial'],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        var chart = new ApexCharts(document.querySelector("#chart-pie"), options);
        chart.render();
    </script>

    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables-init.js') }}"></script>
    <script src="{{ asset('assets/js/chosen.jquery.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // $('#alertCamposEmBranco').hide();
        // document.getElementById('valorMinimo').addEventListener('input', function(e) {
        //     let value = e.target.value.replace(/\D/g, ''); // Remove tudo que não é número
        //     value = (value / 100).toFixed(2) + '';
        //     value = value.replace(".", ",");
        //     value = value.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
        //     e.target.value = value;
        // });
        // document.getElementById('valorMaximo').addEventListener('input', function(e) {
        //     let value = e.target.value.replace(/\D/g, ''); // Remove tudo que não é número
        //     value = (value / 100).toFixed(2) + '';
        //     value = value.replace(".", ",");
        //     value = value.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
        //     e.target.value = value;
        // });
    </script>
    @stack('scripts')
</body>

</html>

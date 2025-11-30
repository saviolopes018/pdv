@extends('components.app')

@section('content')
    <div class="content animated fadeIn">
        <div class="col-md-12 mt-3">
            <h2 class="pb-2 display-5">Estoque</h2>
        </div>

        <div class="col-md-12">
            <div class="d-flex justify-content-end bottom-pull-right">
                <a href="{{ route('estoque.registrar') }}" class="btn btn-primary" title="Entrada ou Saída"><i class="fa fa-right-left"></i>&nbsp;
                    Registrar</a>
            </div>
        </div>

        <div class="col-md-12">
            @if (session('message-success'))
                <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                    <span class="badge badge-pill badge-success">Sucesso</span>
                    {{ session('message-success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <table id="bootstrap-data-table-export" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Quantidade</th>
                                <th>Data da Movimentação</th>
                                <th>Tipo de Movimentação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($listEstoque as $estoque)
                                <tr>
                                    <td>{{ $estoque->descricaoProduto }}</td>
                                    <td>{{ $estoque->quantidade }}</td>
                                    <td>{{ \Carbon\Carbon::parse($estoque->dataMovimentacao)->format('d/m/Y') }}</td>
                                    <td>
                                    @if($estoque->tipoMovimentacao == 1)
                                    <span class="badge badge-success">Entrada</span>
                                    @else
                                    <span class="badge badge-danger">Saída</span>
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
@endsection

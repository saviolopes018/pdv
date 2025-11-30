@extends('components.app')

@section('content')
    <div class="content animated fadeIn">
        <div class="col-md-12 mt-3">
            <h2 class="pb-2 display-5">Produtos</h2>
        </div>

        <div class="col-md-12">
            <div class="d-flex justify-content-end bottom-pull-right">
                <a href="{{ route('produto.adicionar') }}" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;
                    Adicionar</a>
            </div>
        </div>

        <div class="col-md-12">
            @if (session('message-success'))
                <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                    <span class="badge badge-pill badge-success">Sucesso</span>
                    {{ session('message-success') }} <a href="{{ route('estoque.listagem') }}" style="color: #155724; font-weight: 500; text-decoration: none;">Deseja dar entrada no estoque?</a>
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
                                <th>Valor de Compra</th>
                                <th>Margem</th>
                                <th>Valor de Venda</th>
                                <th>Código</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listProdutos as $produto)
                                <tr>
                                    <td>{{ $produto->produto }}</td>
                                    <td>R$ {{ number_format($produto->valorCompra, 2, ',', '.') }}</td>
                                    <td>{{ $produto->margem }}%</td>
                                    <td>R$ {{ number_format($produto->valorVenda, 2, ',', '.') }}</td>
                                    <td>{{ $produto->codigo }}</td>
                                    <td>
                                        <a class="btn btn-info btn-sm btn-icon-actions" href="{{ route('produto.editar', $produto->id) }}" title="Editar"><i class="fa fa-edit"></i></a>
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

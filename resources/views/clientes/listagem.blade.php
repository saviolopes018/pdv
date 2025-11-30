@extends('components.app')

@section('content')
    <div class="content animated fadeIn">
        <div class="col-md-12 mt-3">
            <h2 class="pb-2 display-5">Clientes</h2>
        </div>

        <div class="col-md-12">
            <div class="d-flex justify-content-end bottom-pull-right">
                <a href="{{ route('clientes.cadastro') }}" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp; Novo
                    Cliente</a>
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
                                <th>Cliente</th>
                                <th>Telefone</th>
                                <th>CPF</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clientes as $cliente)
                                <tr>
                                    <td>{{ $cliente->primeiroNome }} {{ $cliente->sobrenome }}</td>
                                    <td>{{ $cliente->telefone }}</td>
                                    <td>{{ $cliente->cpf }}</td>
                                    <td>
                                        @if ($cliente->status == 1)
                                            <span
                                                class="badge badge-success">{{ getLabelAtivoPorCodigo($cliente->status) }}</span>
                                        @else
                                            <span
                                                class="badge badge-danger">{{ getLabelAtivoPorCodigo($cliente->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-sm btn-icon-actions" href="{{ route('clientes.editar', $cliente->id) }}" title="Editar"><i class="fa fa-edit"></i></a>
                                        @if($cliente->status == 0)
                                            <a class="btn btn-success btn-sm btn-icon-actions" href="{{ route('clientes.ativar', $cliente->id) }}" title="Ativar"><i class="fa fa-user-check"></i></a>
                                        @else
                                            <a class="btn btn-danger btn-sm btn-icon-actions" href="{{ route('clientes.inativar', $cliente->id) }}" title="Inativar"><i class="fa fa-user-xmark"></i></a>
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

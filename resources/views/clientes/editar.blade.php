@extends('components.app')

@section('content')
    <div class="content animated fadeIn">
        <div class="col-md-12 mt-3">
            <h2 class="pb-2 display-5">Clientes</h2>
        </div>
        <div class="col-md-12 bottom-pull-right">
            <div class="d-flex justify-content-end">
                <a href="{{ route('clientes.listagem') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i>&nbsp;
                    Voltar</a>
            </div>
        </div>
        <div class="col-lg-12">
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Os seguintes campos são obrigatórios.</h4>
                    <p style="color:#000">
                        @foreach ($errors->all() as $key => $error)
                            {{ $error }}@if (array_key_last($errors->all()) == $key)
                            . @else,
                            @endif
                        @endforeach
                    </p>
                    <hr>
                    <p class="mb-0" style="color:#000">Preencha e tente novamente!</p>
                </div>
            @endif
            @if (session('error'))
                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                    <span class="badge badge-pill badge-danger">Erro</span>
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <p class="p-span-required">Os campos que estão com <span class="span-required">*</span> são
                        obrigatórios.</p>
                </div>
                <div class="card-body card-block">
                    <form id="stepperForm" method="POST" action="{{ route('clientes.atualizar', $cliente->id) }}">
                        @method('PUT')
                        @csrf
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                    aria-controls="home" aria-selected="true">Dados Pessoais e Empresariais <i
                                        class="fa fa-file-text-o"></i></a>
                            </li>
                        </ul>
                        <div class="tab-content pl-3 p-1" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                <br>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="primeiroNome" class="form-control-label">Nome <span
                                                    class="span-required">*</span></label>
                                            <input type="text" id="primeiroNome" name="primeiroNome" class="form-control"
                                                autocomplete="off" value="{{ $cliente->primeiroNome }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="sobrenome" class="form-control-label">Sobrenome <span
                                                    class="span-required">*</span></label>
                                            <input type="text" id="sobrenome" name="sobrenome" class="form-control"
                                                autocomplete="off" value="{{ $cliente->sobrenome }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="dataNascimento" class="form-control-label">Data de Nascimento <span
                                                    class="span-required">*</span></label>
                                            <input type="date" id="dataNascimento" name="dataNascimento"
                                                class="form-control" autocomplete="off" value="{{ $cliente->dataNascimento }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="cpf" class="form-control-label">CPF <span
                                                    class="span-required">*</span></label>
                                            <input type="text" id="cpf" name="cpf" class="form-control"
                                                autocomplete="off" value="{{ $cliente->cpf }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="email" class="form-control-label">Email </label>
                                            <input type="email" id="email" name="email" class="form-control"
                                                autocomplete="off" value="{{ $cliente->email }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="telefone" class="form-control-label">Telefone (WhatsApp) <span
                                                    class="span-required">*</span></label>
                                            <input type="text" id="telefone" name="telefone" class="form-control"
                                                autocomplete="off" value="{{ $cliente->telefone }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="endereco" class="form-control-label">Endereço <span
                                                    class="span-required">*</span></label>
                                            <input type="text" id="endereco" name="endereco" class="form-control"
                                                autocomplete="off" value="{{ $cliente->endereco }}">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="numero" class="form-control-label">Número <span
                                                    class="span-required">*</span></label>
                                            <input type="number" id="numero" name="numero" class="form-control"
                                                autocomplete="off" value="{{ $cliente->numero }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="bairro" class="form-control-label">Bairro <span
                                                    class="span-required">*</span></label>
                                            <input type="text" id="bairro" name="bairro" class="form-control"
                                                autocomplete="off" value="{{ $cliente->bairro }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="cidade" class="form-control-label">Cidade <span
                                                    class="span-required">*</span></label>
                                            <input type="text" id="cidade" name="cidade" class="form-control"
                                                autocomplete="off" value="{{ $cliente->cidade }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="estado" class="form-control-label">Estado <span
                                                    class="span-required">*</span></label>
                                            <input type="text" id="estado" name="estado" class="form-control"
                                                autocomplete="off" value="{{ $cliente->estado }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="cnpj" class="form-control-label">CNPJ </label>
                                            <input type="text" id="cnpj" name="cnpj" class="form-control"
                                                autocomplete="off" value="{{ $cliente->cnpj }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="razaoSocial" class="form-control-label">Razão Social </label>
                                            <input type="text" id="razaoSocial" name="razaoSocial"
                                                class="form-control" autocomplete="off" value="{{ $cliente->razaoSocial }}">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="nomeFantasia" class="form-control-label">Nome Fantasia </label>
                                            <input type="text" id="nomeFantasia" name="nomeFantasia"
                                                class="form-control" autocomplete="off" value="{{ $cliente->nomeFantasia }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 bottom-pull-right">
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-success pull-right">Salvar <i
                                                    class="fa fa-paper-plane"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection

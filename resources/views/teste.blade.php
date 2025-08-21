@extends('components.app')

@section('content')
    <div class="col-md-12">
        <h2 class="pb-2 display-5">Categorias</h2>
    </div>
    <div class="col-md-12" style="margin-bottom: 10px;">
        <div class="d-flex justify-content-end">
            <a href="{{ route('categoria.listagem') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i>&nbsp; Voltar</a>
        </div>
    </div>
    <div class="col-lg-12">
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Os seguintes campos são obrigatórios.</h4>
                <p style="color:#000">
                    @foreach ($errors->all() as $key => $error)
                    {{ $error }}@if(array_key_last($errors->all()) == $key). @else, @endif
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
                <strong class="card-title">#</strong>
            </div>
            <div class="card-body card-block">
                <form id="stepperForm" method="POST" action="{{ route('email.enviar') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nome" class="form-control-label">Nome <span
                                                class="span-required">*</span></label>
                                <input type="text" id="nome" name="nome" class="form-control" autocomplete="off">
                            </div>
                        </div>
                         <div class="col-md-4">
                            <div class="form-group">
                                <label for="email" class="form-control-label">Email <span
                                                class="span-required">*</span></label>
                                <input type="email" id="email" name="email" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="mensagem" class="form-control-label">Mensagem <span
                                                class="span-required">*</span></label>
                                <input type="text" id="mensagem" name="mensagem" class="form-control" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row pull-right">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success btn-md m-l-10 m-b-10">
                                <i class="fa fa-send"></i> Salvar
                            </button>
                            <button type="reset" class="btn btn-warning btn-md m-l-10 m-b-10">
                                <i class="fa fa-trash"></i> Limpar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

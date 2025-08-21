@extends('components.app')

@section('content')
    <div class="content animated fadeIn">
        <div class="col-md-12 mt-3">
            <h2 class="pb-2 display-5">Categorias</h2>
        </div>
        <div class="col-md-12 bottom-pull-right">
            <div class="d-flex justify-content-end">
                <a href="{{ route('categoria.listagem') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i>&nbsp;
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
                    <form id="stepperForm" method="POST" action="{{ route('categoria.atualizar', $categoria->id) }}">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="descricao" class="form-control-label">Descrição <span
                                            class="span-required">*</span></label>
                                    <input type="text" id="descricao" name="descricao" class="form-control"
                                        autocomplete="off" value="{{$categoria->descricao}}">
                                </div>
                            </div>
                        </div>
                        <div class="row pull-right">
                            <div class="col-md-12 d-flex justify-content-end" style="gap:5px;">
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
    </div>
@endsection

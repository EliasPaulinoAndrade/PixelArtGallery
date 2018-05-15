@extends('adminlte::page')

@section('title', 'Galeria de Arte')

@section('content_header')

@stop

@section('content')
<div class="box-body">
    <div class="box box-primary box-solid">
        <div class="box-footer">
            <span class=" profile-username text-capitalize" style="line-height: 30px; max-height: 30px; overflow:hidden; display:block">
                <a href="#" class="text-blue">Adicionar Peça</a>
            </span>
        </div>
        <div class="box-body">
            {{ Form::open(['files' => true, 'method' => 'post', 'route' => ['peca.store']]) }}
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nome: </label>
                        <input type="text" name="nome" class="form-control" id="tituloNovo" placeholder="Digite O Nome ...">
                        <br>
                        <label for="exampleInputEmail1">Descricao: </label>
                        <textarea type="text" name="descricao" class="form-control" id="tituloNovo" placeholder="Digite Uma Descrição ..."></textarea>
                        <br>
                        <label for="exampleInputEmail1">Imagem: </label>
                        <input type="file" name="imagem">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    {{ Form::submit('Registrar', ['class' => 'btn btn-default']) }}
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

@stop

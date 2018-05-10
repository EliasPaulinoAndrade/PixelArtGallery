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
            {{ Form::open(['method' => 'PUT', 'route' => ['peca.update', $peca->id]]) }}
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nome: </label>
                        <input type="text" name="nome" class="form-control" id="tituloNovo" placeholder="Digite O Nome ..." value = "{{$peca->nome}}">
                        <br>
                        <label for="exampleInputEmail1">Descricao: </label>
                        <textarea type="text" name="descricao" class="form-control" id="tituloNovo" placeholder="Digite O Nome ...">{{$peca->nome}}</textarea>
                        
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
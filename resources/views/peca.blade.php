@extends('adminlte::page')

@section('title', 'Galeria de Arte')

@section('content_header')
    <h1>Inicio</h1>
@stop

@section('content')
<div class="box-body">
    <div class="box box-primary box-solid">
        <div class="box-footer">
            <span class=" profile-username text-capitalize" style="line-height: 30px; max-height: 30px; overflow:hidden; display:block">
                <a href="#" class="text-blue">{{$peca->nome}}</a>
            </span>
        </div>
        <div class="box-body">
            
        </div>
    </div>
</div>

@stop
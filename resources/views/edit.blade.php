@extends('adminlte::page')

@section('title', 'Galeria de Arte')

@section('css')
  <link rel="stylesheet" href="{{ URL::asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
@stop()

@section('content')
<div class="box-body">
    <div class="box box-primary box-solid">
        <div class="box-footer">
            <span class=" profile-username text-capitalize" style="line-height: 30px; max-height: 30px; overflow:hidden; display:block">
                <a href="#" class="text-blue">Editar Peça</a>
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
                        <textarea type="text" name="descricao" class="form-control textarea" id="tituloNovo" placeholder="Digite O Nome ...">{{$peca->descricao}}</textarea>
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
@section('adminlte_js')
    <script type="text/javascript" src="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/bootstrap-slider.min.js"></script>

    <script>
    $(function () {
        $('.textarea').wysihtml5({
            toolbar: { fa: true }
        })
    })
    </script>
@stop

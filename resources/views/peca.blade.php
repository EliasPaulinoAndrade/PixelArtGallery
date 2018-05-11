@extends('adminlte::page')

@section('title', 'Galeria de Arte')

@section('css')
  <link rel="stylesheet" href="{{ URL::asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/css/bootstrap-slider.min.css" rel="stylesheet">
  <style>
    #VOTE .slider-selection {
	    background: #0073b7 ;
    }
    #VOTE .slider-handle {
	    background: #333;
    }
    .category1{
        background:red;
    }
  </style>
@stop()

@section('content_header')
    <section class="content-header">
        <h1>
            Obra
        </h1> 
    </section>
@stop

@section('content')
@php($autor = $peca->autor()->get())
<div class="modal fade" id="modal-default" style="display: none;">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Deseja Mesmo Deletar?</h4>
        </div>
        <div class="modal-footer">
        {{ Form::open(['method' => 'DELETE', 'route' => ['peca.destroy', $peca->id]]) }}
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Deletar</button>
        {{ Form::close() }}
        </div>
    </div>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="box-body">
    <div class="box box-primary box-solid">
        <div class="box-footer">
            <span class=" profile-username text-capitalize" style="line-height: 30px; max-height: 30px; overflow:hidden; display:block">
                <a href="#" class="text-blue">{{$peca->nome}}</a>
            </span>
        </div>
        <div class="box-body" style="text-align: center">
            <div style="margin:auto; display: inline-block;">
                <img src="/storage/pecas_images/{{$peca->imagem}}" alt="..." class="img-responsive pad">
            </div>
        </div>
        @if(Auth::user() && Auth::user()->id == $autor->id)
        <div class="box-footer" style="text-align:center">
            <div style="dispay:inline-block;">
                <a class="btn btn-app" href = "/peca/{{$peca->id}}/edit">
                    <i class="fa fa-edit"></i> Editar
                </a>
                <a class="btn btn-app" >
                    <i class="fa fa-trash" data-toggle="modal" data-target="#modal-default"></i> Deletar
                </a>
            </div>
        </div>
        @endif
        
         <div class="box-footer">
            <!-- Post -->
                <div class="post" style="margin: 15px">
                    <div class="user-block">
                        <img class="img-bordered-sm" src="/storage/perfil_images/{{$autor->img_perfil}}" alt="user image" style="width:50px; height: 50px; margin-right: 10px">
                            <span class="text-muted text-center">
                            <a href="/usuario/{{$autor->id}}">{{$autor->nome}}</a>
                            </span>
                        <span class="description">Postado em - 7:30 PM today</span>
                    </div>
                    <!-- /.user-block -->
                    <p>
                       {!!$peca->descricao!!}
                    </p>
                    
                    </div>
                    <!-- /.post -->
        </div>
        <div class="box-footer">
            <div style="text-align: center">
                <input form="submitForm" name="avaliacao" style="width: 95%; display: inline-block" type="text" value="0" class="slider form-control"
                data-slider-step="1" data-slider-value="{{$avaliacao==null?3:$avaliacao->nota}}" data-slider-orientation="horizontal" data-slider-handle="square"
                data-slider-selection="before" data-slider-tooltip="show" data-slider-enabled = "true" data-slider-id="VOTE"
                data-slider-ticks="[1, 2, 3, 4, 5]" data-slider-ticks-labels='["Péssimo", "Ruim", "Regular", "Bom", "Ótimo"]'>
            </div>
        </div>
    </div>
</div>
<div class="box-body">
    <div class="box box-primary box-solid">
    
        <div class="box-footer">
            <span class=" text-capitalize" style="line-height: 30px; max-height: 30px; overflow:hidden; display:block">
                <span class="box-title"><b>Comentarios</b></span>
            </span>
        </div>
        <div class="box-body">
            <div class="tab-content" style="margin:15px">
              <div class="active tab-pane" id="timeline">
              @foreach($peca->comentarios()->get() as $comentario)
                <!-- Post -->
                <div class="post">
                    <div class="user-block">
                        @php($autor = $comentario->autor()->get())
                        <img class="img-circle img-bordered-sm" src="/storage/perfil_images/{{$autor->img_perfil}}" alt="user image">
                            <span class="username">
                            <a href="/usuario/{{$autor->id}}">{{$autor->nome}}</a>
                            </span>
                        <span class="description">Feito em - 7:30 PM today</span>
                    </div>
                    <!-- /.user-block -->
                    <p>
                       {!! $comentario->descricao !!}
                    </p>

                    @if(Auth::user() && Auth::user()->id == $autor->id)
                    <ul class="list-inline">
                        <li><a href="/peca/{{$comentario->peca_id}}" class="link-black text-sm"><i class="fa fa-trash margin-r-5"></i> Deletar</a></li>
                    </ul>
                    @endif
                    </div>
                    <!-- /.post -->
                @endforeach       
            </div>
        </div>
        </div>
        <div class="box-footer">
            <br>
             {{ Form::open(['id' => 'submitForm', 'method' => 'POST', 'route' => ['comentario.store']]) }}
                {!! csrf_field() !!}
                <textarea class="form-control textarea" rows="3" placeholder="Insira Um Comentario..." name="descricao"
                    style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                </textarea>
                <input type="hidden" name="peca_id" value = "{{$peca->id}}">
                <br>
                <button type="submit" class="btn btn-primary pull-right btn-flat">Enviar</button>
                
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

        var mySlider = $("input.slider").bootstrapSlider(
            {
                tooltip: 'always'
            }
        );
    })
    </script>
@stop
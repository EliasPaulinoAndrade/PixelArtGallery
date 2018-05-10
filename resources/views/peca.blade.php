@extends('adminlte::page')

@section('title', 'Galeria de Arte')

@section('content_header')
    <section class="content-header">
        <h1>
            Obra
        </h1> 
    </section>
@stop

@section('content')
@php($autor = $peca->autor()->get())
<div class="box-body">
    <div class="box box-primary box-solid">
        <div class="box-footer">
            <span class=" profile-username text-capitalize" style="line-height: 30px; max-height: 30px; overflow:hidden; display:block">
                <a href="#" class="text-blue">{{$peca->nome}}</a>
            </span>
        </div>
        <div class="box-body">

            <img src="/storage/pecas_images/{{$peca->imagem}}" alt="..." class="img-responsive pad">
            
        </div>

        @if(Auth::user() && Auth::user()->id == $autor->id)
        <div class="box-footer" style="dispay:block; margin:auto;">
            <a class="btn btn-app" href = "/peca/{{$peca->id}}/edit">
                <i class="fa fa-edit"></i> Editar
            </a>
            <a class="btn btn-app" >
                <i class="fa fa-trash"></i> Deletar
            </a>
        </div>
        @endif

         <div class="box-footer">
            <!-- Post -->
                <div class="post" style="margin: 15px">
                    <div class="user-block">
                        <img class="img-bordered-sm" src="/storage/pecas_images/{{$autor->img_perfil}}" alt="user image" style="width:50px; height: 50px; margin-right: 10px">
                            <span class="text-muted text-center">
                            <a href="/usuario/{{$autor->id}}">{{$autor->nome}}</a>
                            </span>
                        <span class="description">Postado em - 7:30 PM today</span>
                    </div>
                    <!-- /.user-block -->
                    <p>
                       {{$peca->descricao}}
                    </p>
                    
                    </div>
                    <!-- /.post -->
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
                        <img class="img-circle img-bordered-sm" src="/storage/pecas_images/{{$peca->imagem}}" alt="user image">
                            <span class="username">
                            @php($autor = $comentario->autor()->get())
                            <a href="/usuario/{{$autor->id}}">{{$autor->nome}}</a>
                            </span>
                        <span class="description">Feito em - 7:30 PM today</span>
                    </div>
                    <!-- /.user-block -->
                    <p>
                       {{$comentario->descricao}}
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
             {{ Form::open(['method' => 'POST', 'route' => ['comentario.store']]) }}
                {!! csrf_field() !!}
                <textarea class="form-control" rows="3" placeholder="Insira Um Comentario..." name="descricao"></textarea>
                </textarea>
                <input type="hidden" name="peca_id" value = "{{$peca->id}}">
                <br>
                <button type="submit" class="btn btn-primary pull-right btn-flat">Enviar</button>
                
            {{ Form::close() }}
        </div>
    </div>
</div>
@stop
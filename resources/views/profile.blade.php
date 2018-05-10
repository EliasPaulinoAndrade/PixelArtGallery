@extends('adminlte::page')

@section('title', 'Galeria de Arte')

@section('content_header')
    <section class="content-header">
        <h1>
            Perfil
        </h1> 
    </section>
@stop

@section('content')
<section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="/storage/pecas_images/{{$usuario->img_perfil}}" alt="User profile picture">

              <h3 class="profile-username text-center">{{$usuario->nome}}</h3>

              <p class="text-muted text-center">Software Engineer</p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Followers</b> <a class="pull-right">1,322</a>
                </li>
                <li class="list-group-item">
                  <b>Following</b> <a class="pull-right">543</a>
                </li>
              </ul>
              @if(Auth::user() && Auth::user()->id != $usuario->id)
                {{ Form::open(['method' => 'POST', 'route' => ['usuario.seguir', $usuario->id]]) }}
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-primary btn-block">
                        <b>
                            Seguir
                        </b>
                    </button>
                {{ Form::close() }}
              @endif
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">About Me</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa fa-book margin-r-5"></i> Descricao</strong>

              <p class="text-muted">
                {{$usuario->descricao}}
              </p>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab">Obras</a></li>
              <li><a href="#timeline" data-toggle="tab">Comentarios</a></li>

              @if(Auth::user() && Auth::user()->id == $usuario->id)
                <li><a href="#settings" data-toggle="tab">Configurações</a></li>
              @endif
            </ul>
            <div class="tab-content">
              <div class="tab-pane" id="timeline">
                @foreach($usuario->comentarios()->get() as $comentario)
                    <!-- Post -->
                    <div class="post">
                    <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="/storage/pecas_images/{{$usuario->img_perfil}}" alt="user image">
                            <span class="username">
                                <span>{{$usuario->nome}}</span>
                            </span>
                        <span class="description">Shared publicly - 7:30 PM today</span>
                    </div>
                    <!-- /.user-block -->
                    <p>
                        {{$comentario->descricao}}
                    </p>
                    <ul class="list-inline">
                        <li><a href="/peca/{{$comentario->peca_id}}" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> Ver Obra</a></li>
                    </ul>
                    </div>
                    <!-- /.post -->
                @endforeach
              </div>
              <!-- /.tab-pane -->
              <div class="active tab-pane" id="activity">
                <!-- The timeline -->
                @foreach($usuario->pecas()->get() as $peca)
                    <a href="/peca/{{$peca->id}}">
                    <img src="/storage/pecas_images/{{$peca->imagem}}" alt="..." class="margin" width="100">
                    </a>
                @endforeach
              </div>
              <!-- /.tab-pane -->
              @if(Auth::user() && Auth::user()->id == $usuario->id)
              <div class="tab-pane" id="settings">
                {{ Form::open(['class' => 'form-horizontal', 'method' => 'PUT', 'route' => ['usuario.update', $usuario->id]]) }}
                
                    {!! csrf_field() !!}
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Nome</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputName" placeholder="Name" name="nome" value="{{$usuario->nome}}">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputEmail" placeholder="Email" name="email" value="{{$usuario->email}}">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">Descrição</label>

                    <div class="col-sm-10">
                      <textarea class="form-control" id="inputExperience" placeholder="Experience" name="descricao">{{$usuario->descricao}}</textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-default">Atualizar</button>
                    </div>
                  </div>
                {{ Form::close() }}
              </div>
              @endif
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
</section>

@stop
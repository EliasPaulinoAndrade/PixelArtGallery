@extends('adminlte::page')

@section('title', 'Galeria de Arte')

@section('content_header')
    <section class="content-header">
        <h1>
            Obras
        </h1>
    </section>
@stop

@section('content')
<div class="box-body">
    <div class="box box-primary">
        <div class="box-header width-border">
            <span class=" profile-username text-capitalize" style="line-height: 30px; max-height: 30px; overflow:hidden; display:block">
                <a href="#" class="text-blue">{{$title}}</a>
            </span>
        </div>

        <div class="box-body">
            <div class="mailbox-controls">
                <!-- Check all button -->
                <a href=""><button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button></a>
                <div class="pull-right">
                  <span class="username" style="margin-right: 10px">
                    <a href="#">{{($currentLimit-30)."-".$currentLimit}}</a>
                    </span>
                  <div class="btn-group">
                    <a href= {{$currentLimit > 30? ("/peca/$id/".($currentLimit - 60)."/".($currentLimit - 30)) : "#"}}><button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button></a>
                    <a href= "/peca/{{$id}}/{{$currentLimit}}/{{$currentLimit + 30}}"><button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button></a>
                    </div>
                  <!-- /.btn-group -->
                </div>
                <!-- /.pull-right -->
              </div>
            @foreach($pecas as $peca)
                <div style="display: inline-block; text-align: center">
                    <a href = "{{url('/peca')}}/{{$peca->id}}">
                        <img src="{{url('../storage/app/public/perfil_images')}}/{{$peca->imagem}}" style="display:inline-block; width:100px; height:100px;">
                    </a>
                    <br>
                    <span class="box-title"><b>{{$peca->nome}}</b></span>
                    <br>
                    <div style="display:inline-block; height: 10px"></div>
                </div>
            @endforeach
            <div class="mailbox-controls">
                <!-- Check all button -->
                <a href=""><button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button></a>
                 <div class="pull-right">
                  <span class="username" style="margin-right: 10px">
                    <a href="#">{{($currentLimit-30)."-".$currentLimit}}</a>
                    </span>
                  <div class="btn-group">
                    <a href= {{$currentLimit > 30? ("/peca/$id/".($currentLimit - 60)."/".($currentLimit - 30)) : "#"}}><button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button></a>
                    <a href= "{{url('/peca')}}/{{$id}}/{{$currentLimit}}/{{$currentLimit + 30}}"><button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button></a>
                  </div>
                  <!-- /.btn-group -->
                </div>
                <!-- /.pull-right -->
              </div>
        </div>
    </div>
</div>
@stop

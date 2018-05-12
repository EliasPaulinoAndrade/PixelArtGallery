<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosTable extends Migration
{
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('id');

            /*campos*/
            $table->string("nome");
            $table->string("sobrenome");
            $table->string("email")->unique();
            $table->string("senha");

            //link da imagem de perfil
            $table->string("img_perfil")->default("img_padrao.png");
            $table->string("descricao")->default("");

        });

        Schema::create('seguidor_seguido', function(Blueprint $table){
            /*seguidores e seguidos table*/
            $table->integer('seguidor_id')->unsigned()->index();
            $table->foreign('seguidor_id')->references('id')->on('usuarios')->onDelete('cascade');

            $table->integer('seguido_id')->unsigned()->index();
            $table->foreign('seguido_id')->references('id')->on('usuarios')->onDelete('cascade');

            //um usuario nao pode seguir outro mais de uma vez '-'
            $table->primary(['seguidor_id', 'seguido_id']);
        });
    }
    public function down()
    {
        Schema::dropIfExists('avaliacaos');
        Schema::dropIfExists('usuario_usuario');
        Schema::dropIfExists('usuarios');
    }
}

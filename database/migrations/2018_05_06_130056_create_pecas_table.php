<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePecasTable extends Migration
{
    public function up()
    {
        Schema::create('pecas', function (Blueprint $table) {
            $table->increments('id');
            
            /*campos*/
            $table->string("nome");
            $table->string("descricao");
            $table->dateTime("data");
            $table->string("imagem");

            /*chanves estrangeiras*/
            //o autor da peca
            $table->integer('autor_id')->unsigned()->index();
            $table->foreign('autor_id')->references('id')->on('usuarios')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('avaliacaos');
        Schema::dropIfExists('pecas');
    }
}

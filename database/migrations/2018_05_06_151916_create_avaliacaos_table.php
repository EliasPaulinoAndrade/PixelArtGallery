<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvaliacaosTable extends Migration
{
    public function up()
    {
        Schema::create('avaliacaos', function (Blueprint $table) {
            $table->increments('id');

            /*campos*/
            $table->unsignedInteger('nota');
            
            /*campos estrangeiros*/
            //o autor da nota
            $table->integer('autor_id')->unsigned()->index();
            $table->foreign('autor_id')->references('id')->on('usuarios')->onDelete('cascade');

            //a peca em que a nota foi dada
            $table->integer('peca_id')->unsigned()->index();
            $table->foreign('peca_id')->references('id')->on('pecas')->onDelete('cascade');

            //um usuario nao pode votar na mesma obra duas vezes.
            $table->unique(['autor_id', 'peca_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('avaliacaos');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComentariosTable extends Migration
{
    public function up()
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->increments('id');

            /*campos*/
            //texto e data de postagem do comentario
            $table->string('descricao');
            $table->dateTime('data');

            /*chanves estrangeiras*/
            //a peca na qual o comentario foi feito
            $table->integer('peca_id')->unsigned()->index();
            $table->foreign('peca_id')->references('id')->on('pecas')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('comentarios');
    }
}

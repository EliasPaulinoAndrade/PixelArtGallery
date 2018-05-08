<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\QFEloquent\QFModel;

class Comentario extends QFModel{
    protected $fillable = ['descricao', 'data', 'peca_id', 'autor_id'];
    public $timestamps = false;

    public function peca(){
        return $this->myBelongsTo(Peca::class);
    }
    public function autor(){
        return $this->myBelongsTo(Usuario::class, "autor_id");
    }
}

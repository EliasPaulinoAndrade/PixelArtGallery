<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\QFEloquent\QFModel;

class Comentario extends QFModel{
    protected $fillable = ['descricao', 'data', 'peca_id'];
    
    public function peca(){
        return $this->myBelongsTo(Peca::class);
    }
}

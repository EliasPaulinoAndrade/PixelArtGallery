<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Avaliacao extends QFModel
{
    protected $fillable = ['nota', 'autor_id', 'peca_id'];

    public function autor(){
        return $this->belongsTo(Usuario::class);
    }
    
    public function peca(){
        return $this->belongsTo(Peca::class);
    }
}

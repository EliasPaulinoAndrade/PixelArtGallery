<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\QFEloquent\QFModel;

class Avaliacao extends QFModel
{
    protected $fillable = ['nota', 'autor_id', 'peca_id'];
    public $timestamps = false;

    public function autor(){
        return $this->myBelongsTo(Usuario::class, "autor_id");
    }
    
    public function peca(){
        return $this->myBelongsTo(Peca::class);
    }
}

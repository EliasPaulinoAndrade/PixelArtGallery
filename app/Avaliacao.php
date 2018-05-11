<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\QFEloquent\QFModel;
use DB;

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

    public static function getAvaliacaoByAutorAndPeca($autorId, $pecaId){
        $selectQuery = "SELECT * FROM avaliacaos WHERE autor_id = $autorId AND peca_id = $pecaId";
        $result = DB::select($selectQuery);

        if(sizeof($result) == 0){
            return null;
        }
        
        return QFModel::rowQueryToModel($result[0], Avaliacao::class);
    }
}

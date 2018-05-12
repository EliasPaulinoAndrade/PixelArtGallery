<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\QFEloquent\QFModel;
use DB;

class Peca extends QFModel
{
    protected $fillable = ['nome', 'descricao', 'data', 'imagem', 'autor_id'];
    public $timestamps = false;

    /*uma peca tem varios comentarios e um autor*/
    public function comentarios()
    {
        return $this->myHasMany(Comentario::class);
    }

    public function autor()
    {
        return $this->myBelongsTo(Usuario::class, "autor_id");
    }

    /*cada peca pode ser avaliada por diversos ususarios*/
    public function avaliacoes()
    {
        return $this->myHasMany(Avaliacao::class);
    }

    public static function getSortedByDate($limit = null, $offset = null){
        $query = "SELECT * from pecas ORDER BY data";
        $query = $limit != null? $query." LIMIT $limit" : $query;
        $query = $offset != null? $query." OFFSET $offset" : $query;
        
        $pecasByDateResult = DB::select($query);

        $pecasByDate = [];
        foreach($pecasByDateResult as $row){
            array_push($pecasByDate ,QFModel::rowQueryToModel($row, Peca::class));
        }
        return $pecasByDate;
    }

    public static function getBestEvalueted($limit = null, $offset = null){
        $query = "SELECT pecas.*, AVG(nota) AS avgnota " 
                ."FROM pecas, avaliacaos " 
                ."WHERE pecas.id = avaliacaos.peca_id " 
                ."GROUP BY pecas.id "
                ."ORDER BY avgnota DESC, pecas.data";
        
        $query = $limit != null? $query." LIMIT $limit" : $query;
        $query = $offset != null? $query." OFFSET $offset" : $query;

        $pecasByEvaluationResult = DB::select($query);

        $pecasByEvaluation = [];
        foreach($pecasByEvaluationResult as $row){
            array_push($pecasByEvaluation ,QFModel::rowQueryToModel($row, Peca::class));
        }
        return $pecasByEvaluation;
    }

    public function getAVGAvaliacoes(){
        $selectQuery = "SELECT AVG(nota) as sum " 
                      ."FROM avaliacaos, pecas "
                      ."WHERE pecas.id = avaliacaos.peca_id "
                      ."AND pecas.id = $this->id "
                      ."GROUP BY pecas.id";

        $result = DB::select($selectQuery);
        if(sizeof($result) == 0){
            return 0;
        }

        return $result[0]->sum;
    }
}
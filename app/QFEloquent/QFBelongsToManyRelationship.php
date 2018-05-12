<?php

namespace App\QFEloquent;
use DB;

/*representa o relacionamento de "ser de varios"*/
class QFBelongsToManyRelationship implements QFRelationship{

    private $id, $thisSide, $otherSide, $tableName, $thisSideIdName, $otherSideIdName;

    public function __construct($id, $thisSide, $otherSide, $tableName, $thisSideName = null, $otherSideName = null)
    {
        $this->id = $id;
        $this->thisSide = $thisSide;
        $this->otherSide = $otherSide;
        $this->tableName = $tableName;
        $this->thisSideIdName = $thisSideName;
        $this->otherSideIdName = $otherSideName;
        
        if($this->otherSideIdName == null){
            $otherSideIdName = QFDBHelper::tableIdFromOtherTable($otherSide);
        }
        if($this->thisSideIdName == null){
            $thisSideIdName = QFDBHelper::tableIdFromOtherTable($thisSide);
        }

    }

    public function get($limit = null)
    {
        /*percorre a tabela de relacionamento buscando a combinacao das chaves*/

        $thisSideTableName = QFDBHelper::tableNameFromClass($this->thisSide);
        $otherSideTableName = QFDBHelper::tableNameFromClass($this->otherSide);

        $selectQuery = "SELECT $otherSideTableName.* "
                      ."FROM $this->tableName, $otherSideTableName " 
                      ."WHERE $this->tableName.$this->thisSideIdName = $this->id "
                      ."AND $this->tableName.$this->otherSideIdName = $otherSideTableName.id";
        
        if($limit != null){
            $selectQuery = $selectQuery." limit $limit";
        }

        $result = DB::select($selectQuery);

        $modelResult = [];
        foreach($result as $row){
            array_push($modelResult, QFModel::rowQueryToModel($row, $this->otherSide));
        }

        return $modelResult;
    }

    public function add($id)
    {
        /*adiciona um relacionamento na tabela de relacionamento*/

        $addQuery = "INSERT INTO $this->tableName ($this->otherSideIdName, $this->thisSideIdName)
                     VALUES ($id, $this->id)";
    
        return DB::insert($addQuery);
    }

    public function remove($otherId)
    {
        /*remove um relacionamento da tabela*/
        $removeQuery = "DELETE FROM $this->tableName WHERE $this->thisSideIdName = $this->id AND $this->otherSideIdName = $otherId";
        return DB::delete($removeQuery);
    }

    public function count()
    {
        /*conta quantas rows tem do outro lado do relacionamento*/
        $otherSideTableName = QFDBHelper::tableNameFromClass($this->otherSide);
        $countQuery = "SELECT count(*) AS count " 
                     ."FROM $otherSideTableName, $this->tableName " 
                     ."WHERE $this->tableName.$this->thisSideIdName = $this->id " 
                     ."AND $this->tableName.$this->otherSideIdName = $otherSideTableName.id "
                     ."GROUP BY $this->tableName.$this->thisSideIdName";

        $result = DB::select($countQuery);
        if(sizeof($result) == 0){
            return 0;
        }
        return $result[0]->count;
    }

    public function check($otherId)
    {
        /*checa se uma row existe do outro lado do relacionamento*/
        $checkQuery = "SELECT * FROM $this->tableName WHERE $this->otherSideIdName = $otherId AND $this->thisSideIdName = $this->id";
        $result = DB::select($checkQuery);
        return sizeof($result) == 0? false : true;
    }
}

?>
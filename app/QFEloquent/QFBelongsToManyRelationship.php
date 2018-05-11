<?php

namespace App\QFEloquent;
use DB;

/*representa o relacionamento de "ser de varios"*/
class QFBelongsToManyRelationship implements QFRelationship{

    private $id, $thisSide, $otherSide, $tableName, $thisSideIdName, $otherSideIdName;

    public function __construct($id, $thisSide, $otherSide, $tableName, $thisSideName = null, $otherSideName = null){
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

    public function get($limit = null){
        $selectQuery = "SELECT * FROM $this->tableName " 
                      ."WHERE $this->tableName.$this->thisSideIdName = $this->id";
        if($limit != null){
            $selectQuery = $selectQuery." limit $limit";
        }

        $result = DB::select($selectQuery);
        
        $modelResult = [];
        $otherSideModel = null;
        foreach($result as $row){
            $otherSideModel = $this->otherSide::myFind($row->{$this->otherSideIdName});
            array_push($modelResult, $otherSideModel);
        }

        return $modelResult;
    }

    public function add($id){
        $addQuery = "INSERT INTO $this->tableName ($this->otherSideIdName, $this->thisSideIdName)
                     VALUES ($id, $this->id)";
    
        return DB::insert($addQuery);
    }

    public function remove($otherId){
        $removeQuery = "DELETE FROM $this->tableName WHERE $this->thisSideIdName = $this->id AND $this->otherSideIdName = $otherId";
        return DB::delete($removeQuery);
    }

    public function count(){
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

    public function check($otherId){
        $checkQuery = "SELECT * FROM $this->tableName WHERE $this->otherSideIdName = $otherId AND $this->thisSideIdName = $this->id";
        $result = DB::select($checkQuery);
        return sizeof($result) == 0? false : true;
    }
}

?>
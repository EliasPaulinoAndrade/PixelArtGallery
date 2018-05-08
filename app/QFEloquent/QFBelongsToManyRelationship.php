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

    public function get(){
        $selectQuery = "SELECT * FROM $this->tableName WHERE $this->tableName.$this->thisSideIdName = $this->id";
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

    }

    public function remove($id){
        
    }
}

?>
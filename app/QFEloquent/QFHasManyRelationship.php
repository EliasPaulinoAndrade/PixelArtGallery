<?php

namespace App\QFEloquent;
use DB;

class QFHasManyRelationship{
    private $id, $oneSide, $manySide, $oneSideIdName;

    public function __construct($id, $oneSide, $manySide, $oneSideName = null){
        $this->id = $id;
        $this->oneSide = $oneSide;
        $this->manySide = $manySide;
        $this->oneSideIdName = $oneSideName;
        if($this->oneSideIdName == null){
            $this->oneSideIdName = QFDBHelper::tableIdFromOtherTable($oneSide);
        }
    }

    public function get(){
        $oneSideTableName = QFDBHelper::tableNameFromClass($this->oneSide);
        $manySideTableName = QFDBHelper::tableNameFromClass($this->manySide);

        $selectQuery = "SELECT * FROM $manySideTableName WHERE $manySideTableName.$this->oneSideIdName = $this->id";
        $result = DB::select($selectQuery);

        $modelResult = [];
        foreach($result as $row){
            array_push($modelResult, QFModel::rowQueryToModel($row, $this->manySide));
        }

        return $modelResult;
    }
}

?>
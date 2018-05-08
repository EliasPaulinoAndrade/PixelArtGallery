<?php

namespace App\QFEloquent;
use DB;

class QFBelongsToRelationship{

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


        $selectQuery = "SELECT * FROM $manySideTableName WHERE $manySideTableName.id = $this->id";
        
        print($selectQuery);
        $result = DB::select($selectQuery);
        $oneSideID = $result[0]->{$this->oneSideIdName};
        $oneSideModel = $this->oneSide::myFind($oneSideID);

        return $oneSideModel;
    }
}

?>
<?php

namespace App\QFEloquent;
use DB;

/*representa um relacionamento de "pertencer" a alguem*/
class QFBelongsToRelationship implements QFRelationship{

    private $id, $oneSide, $manySide, $oneSideIdName;

    public function __construct($id, $oneSide, $manySide, $oneSideName = null)
    {
        $this->id = $id;
        $this->oneSide = $oneSide;
        $this->manySide = $manySide;
        $this->oneSideIdName = $oneSideName;
        if($this->oneSideIdName == null){
            $this->oneSideIdName = QFDBHelper::tableIdFromOtherTable($oneSide);
        }
    }

    public function get()
    {
        /*percorre o lado "um" buscando alguma row com id igual ao do lado "muito" e retorna ela*/

        $oneSideTableName = QFDBHelper::tableNameFromClass($this->oneSide);
        $manySideTableName = QFDBHelper::tableNameFromClass($this->manySide);

        $selectQuery = "SELECT $oneSideTableName.* FROM $oneSideTableName, $manySideTableName "
                      ."WHERE $oneSideTableName.id = $manySideTableName.$this->oneSideIdName "
                      ."AND $manySideTableName.id = $this->id";

        $result = DB::select($selectQuery);
        if(sizeof($result) == 0){
            return null;
        }

        $model = QFModel::rowQueryToModel($result[0], $this->oneSide);

        return $model;
    }
}

?>
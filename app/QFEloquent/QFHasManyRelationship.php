<?php

namespace App\QFEloquent;
use DB;

/*representa o relacionamento de "ser dono de varios" ou "um para muitos" */

class QFHasManyRelationship implements QFRelationship{
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

    public function get($limit = null)
    {
        /*percorre o lado "muitos" buscando as rows relacionadas ao lado "um" */

        $oneSideTableName = QFDBHelper::tableNameFromClass($this->oneSide);
        $manySideTableName = QFDBHelper::tableNameFromClass($this->manySide);

        $selectQuery = "SELECT * FROM $manySideTableName WHERE $manySideTableName.$this->oneSideIdName = $this->id";
        if($limit != null){
            $selectQuery = $selectQuery." limit $limit";
        }
        
        $result = DB::select($selectQuery);

        $modelResult = [];
        foreach($result as $row){
            array_push($modelResult, QFModel::rowQueryToModel($row, $this->manySide));
        }

        return $modelResult;
    }

    public function count()
    {
        /*retorna o numeros de rows do outro lado do relacionamento, no caso a quantidade 
        de rows do lado "muitos" relacionadas ao lado "um"*/

        $manySideTableName = QFDBHelper::tableNameFromClass($this->manySide);

        $countQuery = "SELECT count(*) AS count " 
                     ."FROM $manySideTableName " 
                     ."WHERE $manySideTableName.$this->oneSideIdName = $this->id " 
                     ."GROUP BY $manySideTableName.$this->oneSideIdName";

        $result = DB::select($countQuery);

        if(sizeof($result) == 0){
            return 0;
        }
        return $result[0]->count;
    }

    public function check($otherId)
    {
        /*checa se relacionamento existe, percorre o lado "muitos" buscando algum que pertenca 
        ao lado "um" */

        $manySideTableName = QFDBHelper::tableNameFromClass($this->manySide);

        $checkQuery = "SELECT * FROM $manySideTableName WHERE $manySideTableName.$this->oneSideIdName = $this->id AND $manySideTableName.id = $otherId";
        $result = DB::select($checkQuery);
        return sizeof($result) == 0? false : true;
    }
}

?>
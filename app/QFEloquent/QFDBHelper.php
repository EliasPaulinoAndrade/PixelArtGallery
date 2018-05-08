<?php

namespace App\QFEloquent;
use DB;

class QFDBHelper
{
    public static function tableNameFromClass($name){
        $calledClassExploded = explode('\\', $name);
        $calledClassName = $calledClassExploded[sizeof($calledClassExploded) - 1];
        $tableName = strtolower($calledClassName).'s'; 
        
        return $tableName;
    }

    public static function tableIdFromOtherTable($name){
        $calledClassExploded = explode('\\', $name);
        $calledClassName = $calledClassExploded[sizeof($calledClassExploded) - 1];
        $tableName = strtolower($calledClassName) . "_id"; 
        
        return $tableName;
    }

    public static function fieldsFromTableWithName($tableName){
        $columnsInfo = DB::select("SHOW COLUMNS FROM $tableName");
        $columnsNames = [];

        foreach($columnsInfo as $columnInfo){
            array_push($columnsNames, $columnInfo->Field);
        }
        return $columnsNames;
    }
}
?>
<?php

namespace App\QFEloquent;
use DB;

class QFDBHelper
{
    public static function tableNameFromClass($name)
    {
        /*retorna o nome de tabela padrao dado o nome de uma classe, que 
        é a simples adicao de "s" no final, tudo lowercase*/

        $calledClassExploded = explode('\\', $name);
        $calledClassName = $calledClassExploded[sizeof($calledClassExploded) - 1];
        $tableName = strtolower($calledClassName).'s'; 
        
        return $tableName;
    }

    public static function tableIdFromOtherTable($name)
    {
        /*retorna retorna o nome padrao para um modelo em outra tabela ,
        por exemplo: nome padrao de Usuario é usuario_id*/

        $calledClassExploded = explode('\\', $name);
        $calledClassName = $calledClassExploded[sizeof($calledClassExploded) - 1];
        $tableName = strtolower($calledClassName) . "_id"; 
        
        return $tableName;
    }

    public static function fieldsFromTableWithName($tableName)
    {
        /*peca todos os campos para uma tabela com um nome dado, usando o comando shows*/

        $columnsInfo = DB::select("SHOW COLUMNS FROM $tableName");
        $columnsNames = [];

        foreach($columnsInfo as $columnInfo){
            array_push($columnsNames, $columnInfo->Field);
        }
        return $columnsNames;
    }
}
?>
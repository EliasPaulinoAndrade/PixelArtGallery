<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Schema;

class QFModel extends Model
{
    public static function myFind($id)
    {
        /*procura um model pelo id, supondo que id é sempre a primary key da tabela, e supondo que
        a tabela do modelo tem nome padrao lower case com 's' no final*/
        $calledClassNameAbs = get_called_class();
        $calledClassExploded = explode('\\', $calledClassNameAbs);
        $calledClassName = $calledClassExploded[sizeof($calledClassExploded) - 1];
        $tableName = strtolower($calledClassName).'s';
        $query = "select * from $tableName where id = $id";
        
        $result = get_object_vars(DB::select($query)[0]);

        $classInstance = new $calledClassName();
        foreach($result as $key => $value){
            $classInstance[$key] = $value;
        }

        return $classInstance;
    }

    public function mySave(){
        $thisClassNameAbs = get_class($this);
        $thisClassExploded = explode('\\', $thisClassNameAbs);
        $thisClassName = $thisClassExploded[sizeof($thisClassExploded) - 1];
        $tableName = strtolower($thisClassName).'s';

        $tableFields = Schema::getColumnListing($tableName);
        
        /*parei aqui*/
    }
}

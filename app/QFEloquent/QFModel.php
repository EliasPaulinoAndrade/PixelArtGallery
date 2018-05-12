<?php

namespace App\QFEloquent;

use Illuminate\Database\Eloquent\Model;
use DB;
use Schema;
/*
Esse modelo foi implementado devido a impossibilidade de utilizar os methodos do eloquent no projeto.

todos os metodos sao feitos com os presupostos:
* a primary key de todos os modelos é 'id'
* o nome da tabela de um modelo é conseguido por meio do acrescimo de um 's' no final do nome 
do modelo, tudo caixa baixa

*/


class QFModel extends Model
{

    public static function myFind($id)
    {   
        /*procura um modelo pelo id*/

        $calledClassNameAbs = get_called_class();
        $tableName = QFDBHelper::tableNameFromClass($calledClassNameAbs);
        $query = "select * from $tableName where id = $id";
        
        $result = DB::select($query);
        $classInstance = QFModel::rowQueryToModel($result[0], $calledClassNameAbs);

        return $classInstance;
    }

    public function mySave()
    {
        /*salva um modelo no banco, se ele ja tiver id, redireciona para o update*/

        if($this->id != null){
            return $this->myUpdate();
        }

        $thisClassNameAbs = get_class($this);
        $tableName = QFDBHelper::tableNameFromClass($thisClassNameAbs);
        $columnNames = QFDBHelper::fieldsFromTableWithName($tableName);

        $saveBeginQuery = "INSERT INTO $tableName (";
        $saveEndQuery = ") VALUES (";

        $noFirstComma = true;
        foreach($columnNames as $index => $columnName){
            if($this[$columnName] != null){
                if($noFirstComma){
                    $noFirstComma = false;
                }
                else{
                    $saveBeginQuery .= ", ";
                    $saveEndQuery .= ", ";
                }
                $saveBeginQuery .= $columnName;
                $saveEndQuery .= "'" . $this[$columnName] . "'"; 
            }  
        }

        $saveQuery = $saveBeginQuery . $saveEndQuery . ")";
        $insertResult = DB::insert($saveQuery);

        $lastId = DB::select("SELECT id FROM $tableName ORDER BY id DESC limit 1");

        $this->id = $lastId[0]->id;

        return $insertResult;
    }

    public function myUpdate()
    {
        /*atualiza um modelo no banco, se ele nao tiver id ainda, redireciona para o salvar*/
    
        if($this->id == null){
            return $this->mySave();
        }

        $thisClassNameAbs = get_class($this);
        $tableName = QFDBHelper::tableNameFromClass($thisClassNameAbs);
        $columnNames = QFDBHelper::fieldsFromTableWithName($tableName);

        $updateBeginQuery = "UPDATE $tableName SET ";
        $updateEndQuery = " WHERE $tableName.id = $this->id";

        $noFirstComma = true;
        foreach($columnNames as $index => $columnName){
            if($this[$columnName] != null){
                if($noFirstComma){
                    $noFirstComma = false;
                }
                else{
                    $updateBeginQuery .= ", ";
                }
                $updateBeginQuery .= $columnName . " = \"" . $this[$columnName] . "\"";
            }  
        }

        $updateQuery = $updateBeginQuery . $updateEndQuery ;

        return DB::update($updateQuery);
    }

    public function myDelete()
    {
        /*deleta o registor de um modelo no banco*/

        if($this->id == null){
            return 0;
        }

        $thisClassNameAbs = get_class($this);
        $tableName = QFDBHelper::tableNameFromClass($thisClassNameAbs);

        $deleteQuery = "DELETE FROM $tableName WHERE id = $this->id";
        return DB::delete($deleteQuery);
    }

    public static function rowQueryToModel($row, $className){
        /*retorna a instancia de uma classe a partir de uma row resultante de uma query*/

        $result = get_object_vars($row);
        
        $classInstance = new $className();
        foreach($result as $key => $value){
            $classInstance[$key] = $value;
        }

        return $classInstance;
    }

    /*para cada chamada de relacionamento é criado um objeto de guarda as informacoes de relacionamento
    e faz queries com base nele*/
    public function myHasMany($otherClass, $oneSideIdName = null){

        /*retorna uma nova instancia de um modelo de relacionamento um para muitos*/
        return new QFHasManyRelationship($this->id, get_class($this), $otherClass, $oneSideIdName);
    }

    public function myBelongsTo($otherClass, $oneSideIdName = null){

        /*retorna uma nova instancia de um modelo de relacionamento muitos para um*/

        return new QFBelongsToRelationship($this->id, $otherClass, get_class($this), $oneSideIdName);
    }

    public function myBelongsToMany($otherClass, $tableName, $thisSideName = null, $otherSideName = null){
        
        /*retorna uma nova instancia de um modelo de relacionamento muitos para muitos*/

        return new QFBelongsToManyRelationship($this->id, get_class($this), $otherClass, $tableName, $thisSideName, $otherSideName);
    }
}

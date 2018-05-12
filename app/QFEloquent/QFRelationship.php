<?php
namespace App\QFEloquent;
use DB;

interface QFRelationship{
    /*metodo para pegar a query de uma relacao*/
    public function get();
}

?>
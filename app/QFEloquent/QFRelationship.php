<?php
namespace App\QFEloquent;
use DB;

interface QFRelationship{
    /*chamada para pegar a query de uma relacao*/
    public function get();
}

?>
<?php
namespace App\QFEloquent;
use DB;

interface QFRelationship{
    /*chamada para pegar a query de uma relacao*/
    public function get();
    /*adiciona um item ao lado oposto da relacao*/
    public function add($id);
    /*remove um item do lado oposto da relacao*/
    public function remove($id);
}

?>
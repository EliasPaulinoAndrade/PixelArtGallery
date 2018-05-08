<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\QFEloquent\QFModel;

class Peca extends QFModel
{
    protected $fillable = ['nome', 'descricao', 'data', 'imagem', 'autor_id'];

    /*uma peca tem varios comentarios e um autor*/
    public function comentarios()
    {
        return $this->myHasMany(Comentario::class);
    }

    public function autor()
    {
        return $this->myBelongsTo(Usuario::class, "autor_id");
    }

    /*cada peca pode ser avaliada por diversos ususarios*/
    public function avaliacoes()
    {
        return $this->myHasMany(Avaliacao::class);
    }
}
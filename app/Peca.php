<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Peca extends Model
{
    protected $fillable = ['nome', 'descricao', 'data', 'imagem'];

    /*uma peca tem varios comentarios e um autor*/
    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function autor()
    {
        return $this->belongsTo(Usuario::class);
    }
}

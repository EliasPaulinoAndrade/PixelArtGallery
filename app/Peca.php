<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Peca extends Model
{
    protected $fillable = ['nome', 'descricao', 'data', 'imagem', 'autor_id'];

    /*uma peca tem varios comentarios e um autor*/
    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function autor()
    {
        return $this->belongsTo(Usuario::class);
    }

    /*cada peca pode ser avaliada por diversos ususarios*/
    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class);
    }
}

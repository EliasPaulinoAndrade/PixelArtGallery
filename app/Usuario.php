<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $fillable = ['email', 'senha', 'img_perfil', 'descricao', 'nome'];
    protected $hidden = ['senha'];

    /*um usuario pode postar varias pecas*/
    public function pecas()
    {
        return $this->hasMany(Peca::class);
    }

    /*cada usuario tem varios seguidores, e pode ser seguido por varios*/
    public function seguidores()
    {
        return $this->belongsToMany(Usuario::class, "seguidor_seguido", "seguido_id", "seguidor_id");
    }

    public function seguindo()
    {
        return $this->belongsToMany(Usuario::class, "seguidor_seguido", "seguidor_id", "seguido_id");
    }

}

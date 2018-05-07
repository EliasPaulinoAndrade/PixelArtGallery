<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
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

    /*cada usuario pode fazer varias avaliacoes a pecas diferentes*/
    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class, 'autor_id');
    }

    public function getAuthIdentifierName()
    {
        return 'email'; 
    }

    public function getAuthPassword()
    {
        return $this->senha;
    }

    public function getRememberToken(){
        return null;
    }

    public function getRememberTokenName()
    {
        return null; // not supported
    }
}

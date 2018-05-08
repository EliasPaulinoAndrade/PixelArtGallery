<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use App\QFEloquent\QFModel;

class Usuario extends QFModel implements AuthenticatableContract, CanResetPasswordContract
{
    protected $fillable = ['email', 'senha', 'img_perfil', 'descricao', 'nome'];
    protected $hidden = ['senha'];

    /*um usuario pode postar varias pecas*/
    public function pecas()
    {
        return $this->myHasMany(Peca::class, "autor_id");
    }

    /*cada usuario tem varios seguidores, e pode ser seguido por varios*/
    public function seguidores()
    {
        return $this->myBelongsToMany(Usuario::class, "seguidor_seguido", "seguido_id", "seguidor_id");
    }

    public function seguindo()
    {
        return $this->myBelongsToMany(Usuario::class, "seguidor_seguido", "seguidor_id", "seguido_id");
    }

    /*cada usuario pode fazer varias avaliacoes a pecas diferentes*/
    public function avaliacoes()
    {
        return $this->myHasMany(Avaliacao::class, 'autor_id');
    }

    public function getAuthIdentifierName()
    {
        return 'email'; 
    }

    public function getAuthIdentifier()
    {
        return $this->email;
    }

    public function getAuthPassword()
    {
        return $this->senha;
    }

    public function getRememberToken(){
        return null;
    }

    public function setRememberToken($value)
    {

    }

    public function getRememberTokenName()
    {
        return null;
    }

    public function getEmailForPasswordReset()
    {

    }

    public function sendPasswordResetNotification($token)
    {

    }
}

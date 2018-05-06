<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $fillable = ['descricao', 'data'];

    public function peca()
    {
        return $this->belongsTo(Peca::class);
    }
}

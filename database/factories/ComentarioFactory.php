<?php

use App\Peca;
use App\Comentario;
use App\Usuario;


$factory->define(Comentario::class, function (Faker\Generator $faker) {
    $fakerBR = Faker\Factory::create("pt_BR");
    return [
        'data' => $fakerBR->dateTime,
        'descricao' => $fakerBR->realText($maxNbChars = 200),
        'peca_id' => $fakerBR->randomElement(Peca::all()->pluck('id')->toArray()),
        'autor_id' =>  $fakerBR->randomElement(Usuario::all()->pluck('id')->toArray()),
    ];
});

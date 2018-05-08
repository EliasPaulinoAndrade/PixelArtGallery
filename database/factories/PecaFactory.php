<?php

use App\Peca;
use App\Usuario;
$factory->define(Peca::class, function (Faker\Generator $faker) {
    $fakerBR = Faker\Factory::create("pt_BR");
    return [
        'nome' => $fakerBR->word,
        'data' => $fakerBR->dateTime,
        'descricao' => $fakerBR->realText($maxNbChars = 200),
        'imagem' => $fakerBR->word.".png",
        'autor_id' => $fakerBR->randomElement(Usuario::all()->pluck('id')->toArray())
    ];
});

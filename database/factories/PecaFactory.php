<?php

use App\Peca;
use App\Usuario;
$factory->define(Peca::class, function (Faker\Generator $faker) {
    $fakerBR = Faker\Factory::create("pt_BR");
    return [
        'nome' => $fakerBR->word,
        'data' => $fakerBR->dateTime,
        'descricao' => $fakerBR->realText($maxNbChars = 200),
        'imagem' => "rand_".$fakerBR->randomElement(["1", "2", "3", "4", '5', '6', '7', '8', '9', '10']).".png",
        'autor_id' => $fakerBR->randomElement(Usuario::all()->pluck('id')->toArray())
    ];
});

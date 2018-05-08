<?php

use App\Usuario;

$factory->define(Usuario::class, function (Faker\Generator $faker) {
    $fakerBR = Faker\Factory::create("pt_BR");
    return [
        'nome' => $fakerBR->name,
        'email' => $fakerBR->unique()->safeEmail,
        'senha' => bcrypt('senha'),

    ];
});

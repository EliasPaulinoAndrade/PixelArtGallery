<?php

use Illuminate\Database\Seeder;
use App\Usuario;

class UsuarioSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Usuario::class, 3)->create();
    }
}

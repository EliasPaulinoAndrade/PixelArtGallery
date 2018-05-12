<?php

use Illuminate\Database\Seeder;
use App\Comentario;

class ComentarioSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Comentario::class, 100)->create();
    }
}

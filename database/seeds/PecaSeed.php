<?php

use Illuminate\Database\Seeder;
use App\Peca;

class PecaSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     
    public function run()
    {
        factory(Peca::class, 50)->create();
    }
}

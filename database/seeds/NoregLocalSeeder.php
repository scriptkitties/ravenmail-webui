<?php

use Illuminate\Database\Seeder;

use App\NoregLocal;

class NoregLocalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(NoregLocal::class, rand(0,10))->create();
    }
}

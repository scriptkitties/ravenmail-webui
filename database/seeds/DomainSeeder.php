<?php

use Illuminate\Database\Seeder;

use App\Domain;

class DomainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('domains')->insert([
            'name' => 'test.test',
            'public' => true,
            'contact' => 'test@test.test'
        ]);

        factory(Domain::class, rand(5, 15))->create();
    }
}

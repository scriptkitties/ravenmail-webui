<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Domain;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'local' => 'test',
            'domain' => 'test.test',
            'password' => bcrypt('test'),
            'admin' => true,
            'active' => true,
        ]);

        foreach (Domain::all() as $domain) {
            factory(User::class, rand(5, 20))->create([
                'domain' => $domain->name,
                'active' => (rand(1, 100) > 20),
            ]);
        }
    }
}

<?php

use Illuminate\Database\Seeder;

class TestUserSeeder extends Seeder
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

        DB::table('users')->insert([
            'local' => 'test',
            'domain' => 'test.test',
            'password' => bcrypt('test'),
            'admin' => true,
            'active' => true,
        ]);
    }
}

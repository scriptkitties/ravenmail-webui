<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DomainSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AliasSeeder::class);
        $this->call(DomainModeratorSeeder::class);
        $this->call(NoregAddressSeeder::class);
    }
}

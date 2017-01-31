<?php

use Illuminate\Database\Seeder;

use App\Domain;
use App\NoregAddress;

class NoregAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Domain::all() as $domain) {
            factory(NoregAddress::class, rand(0,10))->create([
                'domain_uuid' => $domain->uuid
            ]);
        }
    }
}

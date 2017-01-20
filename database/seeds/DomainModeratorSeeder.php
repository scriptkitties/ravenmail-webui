<?php

use Illuminate\Database\Seeder;

use App\Domain;
use App\DomainModerator;

class DomainModeratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Domain::all() as $domain) {
            $user = $domain->users()->first();

            factory(DomainModerator::class)->create([
                'user_uuid' => $user->uuid,
                'domain_uuid' => $user->domain->uuid,
            ]);
        }
    }
}

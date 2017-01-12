<?php

use Illuminate\Database\Seeder;

use App\Alias;
use App\User;

class AliasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(User::all() as $user) {
            if (rand(1, 100) > 90) {
                // lets not overdo it on the amount of aliases
                continue;
            }

            factory(Alias::class, rand(1, 2))->create([
                'local' => $user->local,
                'domain' => $user->domain,
            ]);
        }
    }
}

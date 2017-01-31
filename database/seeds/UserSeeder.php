<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Domain;
use Webpatser\Uuid\Uuid;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // make sure to have an site admin
        DB::table('users')->insert([
            'uuid' => Uuid::generate(4)->string,
            'local' => 'test',
            'domain_uuid' => Domain::findByNameOrFail('test.test')->uuid,
            'password' => bcrypt('test'),
            'admin' => true,
        ]);

        // make sure to have a domain admin
        DB::table('users')->insert([
            'uuid' => Uuid::generate(4)->string,
            'local' => 'admin',
            'domain_uuid' => Domain::findByNameOrFail('test.test')->uuid,
            'password' => bcrypt('test'),
            'admin' => false,
        ]);

        DB::table('domain_moderators')->insert([
            'uuid' => Uuid::generate(4)->string,
            'domain_uuid' => Domain::findByNameOrFail('test.test')->uuid,
            'user_uuid' => User::findByAddressOrFail('admin@test.test')->uuid,
            'admin' => true,
        ]);

        // make sure to have a domain moderator
        DB::table('users')->insert([
            'uuid' => Uuid::generate(4)->string,
            'local' => 'mod',
            'domain_uuid' => Domain::findByNameOrFail('test.test')->uuid,
            'password' => bcrypt('test'),
            'admin' => false,
        ]);

        DB::table('domain_moderators')->insert([
            'uuid' => Uuid::generate(4)->string,
            'domain_uuid' => Domain::findByNameOrFail('test.test')->uuid,
            'user_uuid' => User::findByAddressOrFail('mod@test.test')->uuid,
            'admin' => false,
        ]);

        // make sure to have a normal user
        DB::table('users')->insert([
            'uuid' => Uuid::generate(4)->string,
            'local' => 'user',
            'domain_uuid' => Domain::findByNameOrFail('test.test')->uuid,
            'password' => bcrypt('test'),
            'admin' => false,
        ]);

        foreach (Domain::all() as $domain) {
            factory(User::class, rand(5, 20))->create([
                'domain_uuid' => $domain->uuid,
            ]);
        }
    }
}

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
        // make sure to have an site admin
        DB::table('users')->insert([
            'local' => 'test',
            'domain' => 'test.test',
            'password' => bcrypt('test'),
            'admin' => true,
            'active' => true,
        ]);

        // make sure to have a domain admin
        DB::table('users')->insert([
            'local' => 'admin',
            'domain' => 'test.test',
            'password' => bcrypt('test'),
            'admin' => false,
            'active' => true,
        ]);

        DB::table('domain_moderators')->insert([
            'domain_id' => Domain::findByNameOrFail('test.test')->id,
            'user_id' => User::findByAddressOrFail('admin@test.test')->id,
            'admin' => true,
        ]);

        // make sure to have a domain moderator
        DB::table('users')->insert([
            'local' => 'mod',
            'domain' => 'test.test',
            'password' => bcrypt('test'),
            'admin' => false,
            'active' => true,
        ]);

        DB::table('domain_moderators')->insert([
            'domain_id' => Domain::findByNameOrFail('test.test')->id,
            'user_id' => User::findByAddressOrFail('mod@test.test')->id,
            'admin' => false,
        ]);

        // make sure to have a normal user
        DB::table('users')->insert([
            'local' => 'user',
            'domain' => 'test.test',
            'password' => bcrypt('test'),
            'admin' => false,
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

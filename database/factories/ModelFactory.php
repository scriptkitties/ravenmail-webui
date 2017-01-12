<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use App\Alias;
use App\Domain;
use App\User;

$factory->define(Alias::class, function (Faker\Generator $faker) {
    switch (rand(1, 3)) {
    case 1:
        $destination = $faker->safeEmail;
        break;
    case 2:
        $destination = $faker->freeEmail;
        break;
    case 3:
        $destination = $faker->companyEmail;
        break;
    }

    return [
        'destination' => $destination,
        'userset' => (rand(0, 1) === 0),
        'active' => true,
    ];
});

$factory->define(Domain::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->domainName,
        'public' => true,
        'contact' => 'test@test.test',
    ];
});

$factory->define(User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'local' => $faker->userName,
        'domain' => $faker->domainName,
        'password' => bcrypt('test'),
        'remember_token' => '',
        'admin' => false,
        'active' => true,
    ];
});

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
use App\DomainModerator;
use App\NoregAddress;
use App\User;
use App\Verification;

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
        'verification_uuid' => Verification::generate()->uuid,
    ];
});

$factory->define(Domain::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->domainName,
        'public' => true,
        'contact' => 'test@test.test',
    ];
});

$factory->define(DomainModerator::class, function (Faker\Generator $faker) {
    return [
        'admin' => (rand(0, 1) === 0),
    ];
});

$factory->define(NoregAddress::class, function (Faker\Generator $faker) {
    return [
        'local' => $faker->userName,
    ];
});

$factory->define(User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'local' => $faker->userName,
        'domain_uuid' => Domain::inRandomOrder()->first()->uuid,
        'password' => bcrypt('test'),
        'remember_token' => '',
        'admin' => false,
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Repondant;
use Faker\Generator as Faker;

$factory->define('App\Repondant', function (Faker $faker) {
    return [
        'nom' => $faker->lastName,
        'prenom' => $faker->firstName,
        'mail' => $faker->unique()->safeEmail,
        'user_id' => '',
    ];
});

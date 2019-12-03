<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Formulaire;
use Faker\Generator as Faker;

$factory->define('App\Formulaire', function (Faker $faker) {
    return [
        'libelle' => "Formulaire: ".Str::random(10),
        'user_id' => "",
    ];
});

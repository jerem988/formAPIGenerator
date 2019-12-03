<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Question;
use Faker\Generator as Faker;

$factory->define('App\Question', function (Faker $faker) {
    return [
        'libelle' => $faker->text(30),
        'type' => $faker->randomElement(array('checkbox','radiobox','textarea')),
        'form_id' => '',
    ];
});

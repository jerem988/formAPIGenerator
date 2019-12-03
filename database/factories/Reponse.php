<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Reponse;
use Faker\Generator as Faker;

$factory->define('App\Reponse', function (Faker $faker) {
    return [
        'libelle' =>$faker->text(30),
        'form_id'=>'',
        'question_id'=>''
    ];
});

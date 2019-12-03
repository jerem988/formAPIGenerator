<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ReponsesRepondant;
use Faker\Generator as Faker;

$factory->define('App\ReponsesRepondant', function (Faker $faker) {
    return [
        'form_id'=>'',
        'question_id'=>'',
        'reponse_id'=>'',
        'repondant_id'=>'',
    ];
});

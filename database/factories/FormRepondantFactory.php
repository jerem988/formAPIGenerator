<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\FormRepondant;
use Faker\Generator as Faker;

$factory->define('App\FormRepondant', function (Faker $faker) {
    return [
        'form_id'=>'',
        'repondant_id'=>''
    ];
});

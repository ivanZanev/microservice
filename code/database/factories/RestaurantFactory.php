<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Restaurant;
use Faker\Generator as Faker;

$factory->define(Restaurant::class, function (Faker $faker) {
    return [
        'name' => 'KebapToGo',
		'delivery_time_minutes' => 120
    ];
});

$factory->state(Restaurant::class, 'delivery_60', [
    'delivery_time_minutes' => 60
]);
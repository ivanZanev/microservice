<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Order::class, function (Faker $faker) {
    return [
		'restaurant_id' => 1,
		'estimated_delivery_time' => now()
    ];
});

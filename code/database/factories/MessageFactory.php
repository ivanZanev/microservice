<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Message;
use Faker\Generator as Faker;

$factory->define(Message::class, function (Faker $faker) {
    return [
		'text' => 'test1234',
		'twilio_status' => Message::TWILIO_STATUS_ACCEPTED
    ];
});

$factory->state(Message::class, 'accepted', [
    'twilio_status' => Message::TWILIO_STATUS_SENT,
]);

$factory->state(Message::class, 'failed', [
    'twilio_status' => Message::TWILIO_STATUS_FAILED,
]);

$factory->state(Message::class, 'delivered', [
    'twilio_status' => Message::TWILIO_STATUS_DELIVERED,
]);

$factory->state(Message::class, 'read', [
    'twilio_status' => Message::TWILIO_STATUS_READ,
]);
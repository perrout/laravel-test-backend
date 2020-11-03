<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Property;
use Faker\Generator as Faker;

$factory->define(Property::class, function (Faker $faker) {
    return [
        'id'    => $faker->uuid,
        'email' => $faker->freeEmail,
        'postal' => $faker->postcode,
        'address' => $faker->streetName,
        'number' => $faker->buildingNumber,
        'secondary_address' => $faker->secondaryAddress,
        'neighborhood' => $faker->city,
        'city' => $faker->city,
        'state' => $faker->state,
    ];
});

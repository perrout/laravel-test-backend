<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Contract;
use App\Models\Property;
use Faker\Generator as Faker;

$factory->define(Contract::class, function (Faker $faker) {
    $type = $faker->randomElement( $array = array( 'person', 'company' ) );
    $document = $type === "person" ? $faker->cpf : $faker->cnpj;
    return [
        'property_id' => function () {
            return factory(Property::class)->create()->id;
        },
        'type' => $type,
        'document' => $document,
        'email' => $faker->freeEmail,
        'name' => $faker->firstName . ' ' . $faker->lastName,
        'description' => $faker->paragraphs( 5, true )
    ];
});

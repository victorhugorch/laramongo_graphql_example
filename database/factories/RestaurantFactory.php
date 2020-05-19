<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Factory;
use Faker\Generator as Faker;
use Faker\Provider\pt_BR\Company;

$factory->define(Restaurant::class, function (Faker $faker) {
    $faker = Factory::create();
    $faker->addProvider(new Company($faker));

    return [
        'id' => $faker->uuid,
        'tradingName' => $faker->company,
        'ownerName' => $faker->name,
        'document' => $faker->cnpj,
        'coverageArea' => (object) [
            'type' => 'MultiPolygon',
            'coordinates' => [[[[102.0, 2.0], [103.0, 2.0], [103.0, 3.0],[102.0, 3.0],[102.0, 2.0]]],[[[100.0, 0.0],[101.0, 0.0],[101.0, 1.0],[100.0, 1.0],[100.0, 0.0]],[[100.2, 0.2], [100.8, 0.2],[100.8, 0.8],[100.2, 0.8],[100.2, 0.2]]]]
        ],
        'address' => (object) [
            'type' => 'Point',
            'coordinates' => [-46.57421, -21.785741]
        ]
    ];
});

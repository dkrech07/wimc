<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'CITY' => $faker->city(),
    'COORDS_LATITUDE' => $faker->randomFloat(8, 0, 90),
    'COORDS_LONGITUDE' => $faker->randomFloat(8, -180, 180),
];

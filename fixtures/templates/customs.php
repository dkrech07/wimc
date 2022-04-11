
<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'CODE' => $faker->numberBetween(1, 10),
    'NAMT' => $faker->sentence(10, true),
    'OKPO' => $faker->numberBetween(1, 10),
    'OGRN' => $faker->numberBetween(1, 10),
    'INN' => $faker->numberBetween(1, 10),
    'NAME_ALL' => $faker->sentence(10, true),
    'ADRTAM' => $faker->sentence(10, true),
    'PROSF' => $faker->numberBetween(1, 10),
    'TELEFON' => $faker->sentence(10, true),
    'FAX' => $faker->sentence(10, true),
    'EMAIL' => $faker->sentence(10, true),
    'COORDS_LATITUDE' => $faker->sentence(10, true),
    'COORDS_LONGITUDE' => $faker->sentence(10, true),
];

<?php

$factory->define(App\Brand::class, function (Faker\Generator $faker) {
    return [
        'id' => $faker->unique()->randomNumber(),
        'name' => $faker->name,
        'description' => $faker->word,
    ];
});

$factory->define(App\Car::class, function (Faker\Generator $faker) {
    return [
        'id' => $faker->unique()->randomNumber(),
        'model_id' => function () {
             return factory(App\CarModType::class)->create()->id;
        },
        'price' => $faker->randomNumber(),
        'description' => $faker->word,
    ];
});

$factory->define(App\CarClass::class, function (Faker\Generator $faker) {
    return [
        'id' => $faker->unique()->randomNumber(),
        'name' => $faker->name,
        'description' => $faker->word,
    ];
});

$factory->define(App\CarModType::class, function (Faker\Generator $faker) {
    return [
        'id' => $faker->unique()->randomNumber(),
        'brand_id' => function () {
             return factory(App\Brand::class)->create()->id;
        },
        'hull_id' => function () {
             return factory(App\Hull::class)->create()->id;
        },
        'class_id' => function () {
             return factory(App\CarClass::class)->create()->id;
        },
        'cars_id' => function () {
             return factory(App\Car::class)->create()->id;
        },
    ];
});

$factory->define(App\Hull::class, function (Faker\Generator $faker) {
    return [
        'id' => $faker->unique()->randomNumber(),
        'name' => $faker->name,
        'description' => $faker->word,
    ];
});

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'email_verified_at' => $faker->dateTimeBetween(),
        'password' => bcrypt($faker->password),
        'remember_token' => str_random(10),
    ];
});


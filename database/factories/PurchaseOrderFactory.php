<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PurchaseOrder;
use Faker\Generator as Faker;
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(PurchaseOrder::class, function (Faker $faker) {
    return [
        'user_id' => null,
        'date' => $faker->dateTimeBetween('-5 months', '-3 days'),
    ];
});

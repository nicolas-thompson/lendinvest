<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Loan;
use App\User;
use App\Tranche;
use Illuminate\Support\Str;
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

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->define(Loan::class, function (Faker $faker) {
    return [
        'start' => $faker->dateTime(),
        'end' => $faker->dateTime(),
        'maximum' => 100000,
    ];
});

$factory->define(Tranche::class, function (Faker $faker) {
    return [
        'open' => true,
        'loan_id' => 1,
        'rate' => 3,
        'maximum' => 100000,
    ];
});

$factory->define(Wallet::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'balance' => 100000,
        'rate' => 3,
        'maximum' => 100000,
    ];
});
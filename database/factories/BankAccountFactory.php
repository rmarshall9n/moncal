<?php

use Faker\Generator as Faker;

$factory->define(App\Models\BankAccount::class, function (Faker $faker) {
    return [
        'name' => 'Current Account',
        'user_id' => 1,
    ];
});

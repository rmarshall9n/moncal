<?php

use Faker\Generator as Faker;

$factory->define(App\Models\RecurringTransaction::class, function (Faker $faker) {
    return [
        'name' => 'Bills',
        'amount' => 100.99,
        'start_on' => \Carbon\Carbon::today(),
        'user_id' => 1,
        'repeat_increment' => 1,
        'repeat_type' => 'd',
        'num_repeats' => 10,
        'end_on' => null,
    ];
});

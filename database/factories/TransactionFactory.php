<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Transaction::class, function (Faker $faker) {
    return [
        'name' => 'Bills',
        'amount' => 100.99,
        'made_on' => \Carbon\Carbon::today(),
        'user_id' => 1,
        'recurring_transaction_id' => 1,
    ];
});

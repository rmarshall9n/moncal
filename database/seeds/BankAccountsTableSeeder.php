<?php

use App\Models\BankAccount;
use Illuminate\Database\Seeder;

class BankAccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(BankAccount::class)->create();
        factory(BankAccount::class)->create([
            'name' => 'Savings',
        ]);
    }
}

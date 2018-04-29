<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\RecurringTransaction;

class RecurringTransactionCrudTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_user_can_view_recurring_transactions()
    {
        // arrange
        $transaction = factory(RecurringTransaction::class)->create([
            'name' => 'Bills',
            'amount' => 150.99,
            'start_on' => \Carbon\Carbon::parse('2018-04-20 00:00:00'),
            'repeat_increment' => 1,
            'repeat_type' => 'd',
            'num_repeats' => 10,
        ]);

        // act
        $response = $this->getAuthenticatedResponse()
            ->post('/recurring-transaction/search', []);

        //assert
        $response->assertStatus(200);

        $response->assertJsonFragment([
            "<span>\n\tBills\n</span>\n",
        ]);

        $response->assertJsonFragment([
            "<span>\n\t150.99\n</span>\n",
        ]);

        $response->assertJsonFragment([
            "<span data-order=\"2018-04-20 00:00:00\">\n    \t20 April 2018\n    </span>",
        ]);
    }

    /** @test */
    function a_user_can_create_a_recurring_transaction()
    {
        // arrange
        $data = [
            'name' => 'Bills',
            'amount' => 150.99,
            'start_on' => \Carbon\Carbon::parse('2018-04-20 00:00:00'),
            'repeat_increment' => 1,
            'repeat_type' => 'd',
            'num_repeats' => 10,
        ];

        // act
        $this->getAuthenticatedResponse()
            ->post('recurring-transaction', $data);

        $transaction = RecurringTransaction::first();

        // assert
        $this->assertArraySubset([
            'name' => 'Bills',
            'amount' => 150.99,
            'start_on' => '2018-05-15 00:00:00',
            'repeat_increment' => 1,
            'repeat_type' => 'd',
            'num_repeats' => 10,
        ], $transaction->getAttributes());
    }
}

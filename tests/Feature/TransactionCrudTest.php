<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Transaction;

class TransactionCrudTest extends TestCase
{
    use RefreshDatabase;

    private function getAuthenticatedResponse()
    {
        $user = factory(\App\User::class)->create();
        return $this->actingAs($user);
    }

    /** @test */
    function a_user_can_view_transactions()
    {
        // arrange
        $transaction = factory(Transaction::class)->create([
            'name' => 'Bills',
            'amount' => 150.99,
            'made_on' => \Carbon\Carbon::parse('2018-04-20 00:00:00'),
        ]);

        // act
        $response = $this->getAuthenticatedResponse()
            ->post('/transaction/search', []);

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
    function a_user_can_create_a_transaction()
    {
        // arrange
        $data = [
            'name' => 'Bills',
            'amount' => 150.99,
            'made_on' => \Carbon\Carbon::parse('2018-05-15 00:00:00'),
            'user_id' => 1,
        ];

        // act
        $this->getAuthenticatedResponse()
            ->post('transaction', $data);

        $transaction = Transaction::first();

        // assert
        $this->assertArraySubset([
            'name' => 'Bills',
            'amount' => 150.99,
            'made_on' => '2018-05-15 00:00:00',
        ], $transaction->getAttributes());
    }
}

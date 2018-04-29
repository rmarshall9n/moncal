<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Transaction;

class TransactionTest extends TestCase
{
    /** @test */
    public function a_transaction_can_be_created()
    {
        $transaction = factory(Transaction::class)->make();

        $this->assertEquals('Bills', $transaction->name);
        $this->assertEquals(100.99, $transaction->amount);
        $this->assertEquals(\Carbon\Carbon::today(), $transaction->made_on);
    }
}

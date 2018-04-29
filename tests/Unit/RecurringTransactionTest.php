<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecurringTransactionTest extends TestCase
{
    /** @test */
    public function a_transaction_can_be_created()
    {
        $recurringTransaction = factory(RecurringTransaction::class)->make();

        $this->assertEquals('Bills', $recurringTransaction->name);
        $this->assertEquals(100.99, $recurringTransaction->amount);
        $this->assertEquals(\Carbon\Carbon::today(), $recurringTransaction->start_on);
    }
}

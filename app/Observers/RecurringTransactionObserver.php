<?php

namespace App\Observers;

use App\Models\Transaction;
use App\Models\RecurringTransaction;

class RecurringTransactionObserver
{
    /**
     * Listen to the Recurring Transaction creating event.
     *
     * @param  \App\RecurringTransaction  $recurringTransaction
     * @return void
     */
    // public function creating(RecurringTransaction $recurringTransaction)
    // {

    // }

    /**
     * Listen to the Recurring Transaction saving event.
     *
     * @param  \App\RecurringTransaction  $recurringTransaction
     * @return void
     */
    public function saving(RecurringTransaction $recurringTransaction)
    {
        // If 0, infinite transactions (only go to furthest date)
        // TODO: Should probably update this to be logic based.
        if ($recurringTransaction->num_repeats == 0) {
            throw new \Exception('Can\'t do infinite occurances yet.');
            // $recurringTransaction->end_on = config('app.furthest_date');
        } else {
            // generate the correct end date
            $recurringTransaction->end_on = RecurringTransaction::incrementDate(
                $recurringTransaction->start_on,
                $recurringTransaction->repeat_increment,
                $recurringTransaction->repeat_type,
                $recurringTransaction->num_repeats
            );
        }
    }

    /**
     * Listen to the Recurring Transaction updated event.
     *
     * @param  \App\RecurringTransaction  $recurringTransaction
     * @return void
     */
    public function updated(RecurringTransaction $recurringTransaction)
    {
        // TODO: Only need to change this if the period has changed
        // TODO: Don't delete if they have been saved separately
        Transaction::where('recurring_transaction_id', '=', $recurringTransaction->id)
            ->delete();
    }

    /**
     * Listen to the Recurring Transaction created event.
     *
     * @param  \App\RecurringTransaction  $recurringTransaction
     * @return void
     */
    public function saved(RecurringTransaction $recurringTransaction)
    {
        // TODO: Only need to change this if the period has changed (see updated)
        // regenerate all transactions
        $recurringTransaction->generateTransactions()
            ->each(function ($item) {
                $item->save();
            });
    }
}
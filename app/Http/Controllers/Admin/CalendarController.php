<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Transaction;
use App\Models\RecurringTransaction;
use App\Models\Calendar;
use Illuminate\Http\Request;

class CalendarController extends \App\Http\Controllers\Controller
{
    public function index(Request $request)
    {
        $calendar = new Calendar(
            $request->get('date'),
            $request->get('display')
        );

        $calendar->navigate($request->get('navigate'));

        $transactions = Transaction::where([
                ['transactions.made_on', '>=', $calendar->start_date],
                ['transactions.made_on', '<=', $calendar->end_date],
            ])
            ->get();

        $balances = Transaction::getCumulativeBalances($calendar->start_date, $calendar->end_date);

        $calendar->addItems($transactions);
        $calendar->addBalances($balances);

        return view('calendar', compact('calendar', 'transactions'));
    }
}

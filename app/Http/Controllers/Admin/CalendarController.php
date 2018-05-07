<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\RecurringTransaction;
use App\Models\Calendar;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $calendar = new Calendar(
            $request->get('date'),
            $request->get('display')
        );

        $calendar->navigate($request->get('navigate'));
        $calendar->setupDates();

        $transactions = Transaction::forUser()
            ->whereBetween('transactions.made_on', [
                $calendar->start_date,
                $calendar->end_date
            ])
            ->get();

        $calendar->addEvents($transactions);

        $balances = Transaction::getCumulativeBalances($calendar->start_date, $calendar->end_date);
        $calendar->addBalances($balances);

        return view('calendar.calendar', compact('calendar', 'transactions'));
    }
}

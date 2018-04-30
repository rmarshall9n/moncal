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

        $transactions = collect();//$calendar->getTransactions();

        return view('calendar', compact('calendar', 'transactions'));
    }
}

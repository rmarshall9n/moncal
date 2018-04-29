<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Transaction;
use App\Models\RecurringTransaction;
use App\Models\Calendar;
use Illuminate\Http\Request;

class CalendarController extends \App\Http\Controllers\Controller
{
    public function index($date = null, $display = 'm')
    {
        // Check for valid start date
        try {
            $startDate = $date == null ? Carbon::now() : Carbon::createFromFormat('dmY', $date);
        } catch (\Exception $e) {
            \App::abort('404');
        }

        // check if valid calendar display
        if (!in_array($display, ['d', 'w', 'm', 'y'])) {
            \App::abort('404');
        }

        $calendar = new Calendar($startDate, $display);
        $calendar->initialise();

        $transactions = collect();//$calendar->getTransactions();

        return view('calendar', compact('calendar', 'transactions'));
    }

    public function filter(Request $request)
    {
        // TODO: this seems pretty bad, do an AJAX or something.
        return $this->index($request->input('date'), $request->input('display'));
    }
}

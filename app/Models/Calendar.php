<?php

namespace App\Models;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Calendar
{
    public $display;
    public $date;

    public $events;
    public $balances;

    public $start_date;
    public $end_date;

    public $dates;

    public function __construct($date, $display) {

        // attempt to set a valid date
        try {
            $this->date = Carbon::createFromFormat('Ymd', $date);
        } catch (\Exception $e) {
            $this->date = Carbon::today();
        }

        // set the display view
        $this->display = in_array($display, ['d', 'w', 'm', 'y']) ? $display : 'm';
    }

    public function navigate($action)
    {
        if ($action == 'today') {
            $this->date = Carbon::today();
        } if ($action == 'next') {
            $this->date->addMonthNoOverflow();
        } else if ($action == 'prev') {
            $this->date->subMonthNoOverflow();
        }
    }

    public function setupDates()
    {
        // the first day of the starting week
        $this->start_date = $this->date
            ->copy()
            ->startOfMonth()
            ->startOfWeek();

        $this->dates = [];

        $date = $this->start_date->copy();
        $month = $this->date->format('n');
        $week = 0;

        // figure out all the days and add some meta data
        do {
            for ($day = 0; $day < 7; $day++) {
                $this->dates[$week][] = [
                    'date_id' => $date->format('Ymd'),
                    'day' => $date->format('d'),
                    'in_range' => $date->format('n') == $month,
                    'today' => $date->eq(Carbon::today()),
                ];

                $date->addDay();
            }

            $week++;

        } while ($date->format('n') == $month);

        $this->end_date = $date->subDay()->copy();
    }

    public function getHeadings()
    {
        return [
            'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'
        ];
    }

    public function getEvents($date_id)
    {
        return $this->events[$date_id] ?? [];
    }

    public function getBalance($date_id)
    {
        return $this->balances[$date_id] ?? null;
    }

    public function addEvents($items)
    {
        foreach ($items as $item) {
            $event = $item->getEvent();
            $this->events[(int)$event->dateId()][] = $event;
        }
    }

    public function addBalances($balances)
    {
        foreach ($balances as $balance) {
            $event = new Event($balance->made_on, $balance->balance);
            $this->balances[$event->dateId()] = $event;
        }
    }
}

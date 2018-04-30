<?php

namespace App\Models;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Calendar
{
    public $display;
    public $date;
    // public $currentDate;
    // public $startDate;
    // public $endDate;
    // public $nextDate;
    // public $prevDate;

    // private $openingBalance;
    // private $closingBalance;

    public function __construct($date, $display)
    {
        try {
            $this->date = $date == null ? Carbon::today() : Carbon::createFromFormat('dmY', $date);
        } catch (\Exception $e) {
            $this->date = Carbon::today();
        }

        $this->display = in_array($display, ['d', 'w', 'm', 'y']) ? $display : 'm';
    }

    public function getHeadings()
    {
        return [
            'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'
        ];
    }

    public function getDates()
    {
        $date = $this->date->copy()->startOfMonth()->startOfWeek();
        $month = $this->date->format('n');

        $dates = [];

        for ($i=0; $date->format('n') <= $month; $i++) {
            for ($j = 0; $j < 7; $j++) {
                $dates[$i][] = [
                    'date' => $date->format('d'),
                    'in_range' => $date->format('n') == $month,
                    'today' => $date->eq(Carbon::today()),
                ];

                $date->addDay();
            }
        }

        return $dates;
    }

    public function navigate($action)
    {
        if ($action == 'today') {
            $date = Carbon::today();
        } if ($action == 'next') {
            $this->date->addMonthNoOverflow();
        } else if ($action == 'prev') {
            $this->date->subMonthNoOverflow();
        }
    }





    // public function getOpeningBalance()
    // {
    //     return $this->openingBalance;
    // }

    // public function getClosingBalance()
    // {
    //     return $this->closingBalance;
    // }


    // public function getTransactions()
    // {
    //     // TODO: filter by RT complete flag (to be created)
    //     return Transaction::where('transactions.made_on', '>=', $this->startDate)
    //         ->where('transactions.made_on', '<=', $this->endDate)
    //         ->where('transactions.user_id', Auth::id())
    //         ->withCumulativeBalance()
    //         ->orderBy('transactions.made_on', 'ASC')
    //         ->get();
    // }

    // private function setupBalances()
    // {
    //     $this->openingBalance = Transaction::where('made_on', '<', $this->startDate)
    //         ->sum('amount');

    //     $this->closingBalance = Transaction::where('made_on', '<=', $this->endDate)
    //         ->sum('amount');
    // }

    // private function setupDates()
    // {
    //     // TODO: this feels clunky
    //     switch ($this->display) {
    //         case 'd':
    //             $this->startDate = $this->currentDate->copy();
    //             $this->endDate = $this->currentDate->copy()->tomorrow();
    //             $this->nextDate = $this->currentDate->copy()->addDay();
    //             $this->prevDate = $this->currentDate->copy()->subDay();
    //             break;

    //         case 'w':
    //             $this->startDate = $this->currentDate->copy()->startOfWeek();
    //             $this->endDate = $this->currentDate->copy()->endOfWeek();
    //             $this->nextDate = $this->currentDate->copy()->addWeek();
    //             $this->prevDate = $this->currentDate->copy()->subWeek();
    //             break;

    //         case 'y':
    //             $this->startDate = $this->currentDate->copy()->startOfYear();
    //             $this->endDate = $this->currentDate->copy()->endOfYear();
    //             $this->nextDate = $this->currentDate->copy()->addYear();
    //             $this->prevDate = $this->currentDate->copy()->subYear();
    //             break;

    //         case 'm':
    //         default:
    //             $this->startDate = $this->currentDate->copy()->startOfMonth();
    //             $this->endDate = $this->currentDate->copy()->endOfMonth();
    //             $this->nextDate = $this->currentDate->copy()->addMonth();
    //             $this->prevDate = $this->currentDate->copy()->subMonth();
    //             break;
    //     }
    // }
}

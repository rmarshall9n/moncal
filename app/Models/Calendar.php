<?php

namespace App\Models;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Calendar
{
    public $display;
    public $currentDate;
    public $startDate;
    public $endDate;
    public $nextDate;
    public $prevDate;

    private $openingBalance;
    private $closingBalance;

    public function __construct($currentDate, $display)
    {
        $this->currentDate = $currentDate;
        $this->display = $display;
    }

    public function initialise()
    {
        // $this->setupDates();
        // $this->setupBalances();
    }

    public function getOpeningBalance()
    {
        return $this->openingBalance;
    }

    public function getClosingBalance()
    {
        return $this->closingBalance;
    }


    public function getTransactions()
    {
        // TODO: filter by RT complete flag (to be created)
        return Transaction::where('transactions.made_on', '>=', $this->startDate)
            ->where('transactions.made_on', '<=', $this->endDate)
            ->where('transactions.user_id', Auth::id())
            ->withCumulativeBalance()
            ->orderBy('transactions.made_on', 'ASC')
            ->get();
    }

    private function setupBalances()
    {
        $this->openingBalance = Transaction::where('made_on', '<', $this->startDate)
            ->sum('amount');

        $this->closingBalance = Transaction::where('made_on', '<=', $this->endDate)
            ->sum('amount');
    }

    private function setupDates()
    {
        // TODO: this feels clunky
        switch ($this->display) {
            case 'd':
                $this->startDate = $this->currentDate->copy();
                $this->endDate = $this->currentDate->copy()->tomorrow();
                $this->nextDate = $this->currentDate->copy()->addDay();
                $this->prevDate = $this->currentDate->copy()->subDay();
                break;

            case 'w':
                $this->startDate = $this->currentDate->copy()->startOfWeek();
                $this->endDate = $this->currentDate->copy()->endOfWeek();
                $this->nextDate = $this->currentDate->copy()->addWeek();
                $this->prevDate = $this->currentDate->copy()->subWeek();
                break;

            case 'y':
                $this->startDate = $this->currentDate->copy()->startOfYear();
                $this->endDate = $this->currentDate->copy()->endOfYear();
                $this->nextDate = $this->currentDate->copy()->addYear();
                $this->prevDate = $this->currentDate->copy()->subYear();
                break;

            case 'm':
            default:
                $this->startDate = $this->currentDate->copy()->startOfMonth();
                $this->endDate = $this->currentDate->copy()->endOfMonth();
                $this->nextDate = $this->currentDate->copy()->addMonth();
                $this->prevDate = $this->currentDate->copy()->subMonth();
                break;
        }
    }
}

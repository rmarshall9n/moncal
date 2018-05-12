<?php

namespace App\Http\ViewComposers;

use Carbon\Carbon;
use Illuminate\View\View;
use App\Models\BankAccount;

/**
*
*/
class UpcomingBalanceWidgetComposer
{

    public function compose(View $view)
    {
        $accounts = BankAccount::forUser()->get();
        $dates = [];

        $date = Carbon::now()
            ->endOfMonth();

        for ($i=0; $i < 5; $i++) {
            $dates[] = $date->copy();
            $date->addDay()
                ->endOfMonth();
        }

        $view->with(compact(['accounts', 'dates']));
    }
}
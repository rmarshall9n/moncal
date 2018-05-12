<?php

namespace App\Http\ViewComposers;

use App\Models\BankAccount;
use Illuminate\View\View;

/**
*
*/
class CurrentBalanceWidgetComposer
{

    public function compose(View $view)
    {
        $accounts = BankAccount::forUser()->get();

        $view->with(compact(['accounts']));
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transaction;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
*
*/
class DashboardController extends Controller
{
    public function index()
    {


        return view('vendor.backpack.base.dashboard', compact('someVar'));
    }


    public function storeUpdatedBalance(Request $request)
    {
        $transaction = new Transaction();
        $transaction->name = 'Revised Balance';
        $transaction->made_on = Carbon::now();
        $transaction->user_id = \Auth::id();
        $transaction->amount = $request->updated_balance - Transaction::getCurrentBalance();
        $transaction->account_id = $request->account_id;

        $transaction->save();

        $request->session()->flash('success', 'Balance updated.');

        return redirect('dashboard');
    }
}
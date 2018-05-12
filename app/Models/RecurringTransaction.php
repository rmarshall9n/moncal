<?php

namespace App\Models;

use App\Models\Transaction;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class RecurringTransaction extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'recurring_transactions';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'amount',
        'start_on',
        'user_id',
        'repeat_increment',
        'repeat_type',
        'num_repeats',
        'end_on',
        'bank_account_id',
    ];
    // protected $hidden = [];
    protected $dates = [
        'start_on',
        'end_on',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public static function boot()
    {
        static::creating(function ($model) {
            if (is_null($model->user_id)) {
                $model->user_id = \Auth::id();
            }
        });

        parent::boot();
    }

    public function getRepeatTypes()
    {
        return [
            'd' => 'Day',
            'w' => 'Week',
            'm' => 'Month',
            'y' => 'Year',
        ];
    }



    public static function incrementDate($startOn, $repeatIncrement, $repeatType, $numRepeats = 1)
    {
        if ($repeatType == 'd') {
            return $startOn->copy()->addDay($repeatIncrement * $numRepeats);
        } else if ($repeatType == 'w') {
            return $startOn->copy()->addWeek($repeatIncrement * $numRepeats);
        } else if ($repeatType == 'm') {
            return $startOn->copy()->addMonth($repeatIncrement * $numRepeats);
        } else if ($repeatType == 'y') {
            return $startOn->copy()->addYear($repeatIncrement * $numRepeats);
        }
    }

    public function createTransaction($made_on)
    {
        $transaction = new Transaction;
        $transaction->name = $this->name;
        $transaction->amount = $this->amount;
        $transaction->made_on = $made_on->format('Y-m-d H:i:s');
        $transaction->user_id = $this->user_id;
        $transaction->bank_account_id = $this->bank_account_id;
        $transaction->recurring_transaction_id = $this->id;
        return $transaction;
    }

    public function generateTransactions()
    {
        $transactions = collect();
        $transactionDate = $this->start_on->copy();

        // TODO: This is wrong now, should just check the start + num * repeats * myd
        while ($transactionDate <= $this->end_on) {

            // If the transaction is valid, add it to the collection
            if ($transactionDate <= $this->end_on) {
                $transactions->push($this->createTransaction($transactionDate));
            }

            $transactionDate = self::incrementDate($transactionDate, $this->repeat_increment, $this->repeat_type);
        }

        return $transactions;
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeForUser($query, $userId = null)
    {
        return $query->where('user_id', $userId ?? \Auth::id());
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function getAmountFormattedAttribute()
    {
        return \Formatter::toMoney($this->amount);
    }
}

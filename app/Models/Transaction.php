<?php

namespace App\Models;

use App\Models\Event;
use App\Interfaces\Eventable;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model implements Eventable
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'transactions';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'amount',
        'made_on',
        'user_id',
    ];
    // protected $hidden = [];
    protected $dates = [
        'made_on',
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

    public function getEvent()
    {
        return new Event($this->made_on, $this->amount);
    }

    public static function getCumulativeBalances($startDate, $endDate)
    {
        return \DB::table('transactions')
            ->select(\DB::raw('distinct(transactions.made_on), sum(cumulative.amount) as balance'))
            ->leftJoin('transactions as cumulative', function($join) {
                $join->on('transactions.made_on', '>=', 'cumulative.made_on');
                $join->on('cumulative.user_id', '=', \DB::raw(\Auth::id()));
            })
            ->groupBy('transactions.id')
            ->where([
                ['transactions.made_on', '>=', $startDate],
                ['transactions.made_on', '<=', $endDate],
            ])
            ->orderBy('transactions.made_on')
            ->get();
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

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
}

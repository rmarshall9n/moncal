<?php

namespace App\Models;

use App\Models\Event;
use App\Interfaces\Eventable;
use Backpack\CRUD\CrudTrait;
use Carbon\Carbon;
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
        return new Event($this->made_on, $this->amount, $this->name);
    }

    public static function getCumulativeBalances($startDate, $endDate, $userId = null)
    {
        $userId = $userId ?? \Auth::id();

        return \DB::table('transactions')
            ->select(\DB::raw('distinct(transactions.made_on), sum(cumulative.amount) as balance'))
            ->leftJoin('transactions as cumulative', function($join) {
                $join->on('transactions.made_on', '>=', 'cumulative.made_on');
                $join->on('cumulative.user_id', '=', \DB::raw(\Auth::id()));
            })
            ->groupBy('transactions.id')
            ->whereBetween('transactions.made_on', [$startDate, $endDate])
            // ->where('transactions.user_id', $userId)
            ->orderBy('transactions.made_on')
            ->get();
    }

    public static function getCurrentBalance()
    {
        return self::where('made_on', '<=', Carbon::now()->endOfDay())
            ->where('user_id', \Auth::id())
            ->sum('amount');
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
}

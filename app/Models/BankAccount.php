<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Transaction;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'bank_accounts';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
        'name',
    ];
    // protected $hidden = [];
    // protected $dates = [];

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

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
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
    public function getCurrentBalance()
    {
        return $this->transactions()
            ->whereDate('made_on', '<', Carbon::tomorrow())
            ->sum('amount');
    }

    public function getBalanceOn($date)
    {
        return $this->transactions()
            ->whereDate('made_on', '<', $date)
            ->sum('amount');
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}

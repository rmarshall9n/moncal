<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

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

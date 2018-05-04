<?php

namespace App\Models;

use Carbon\Carbon;

class Event
{
    public $name;
    public $date;
    public $value;

    public function __construct($date, $value)
    {
        $this->date = Carbon::parse($date);;
        $this->value = $value;
    }

    public function dateId()
    {
        return $this->date->format('Ymd');
    }

    public function getClasses()
    {
        return $this->value > 0 ? ' fa-arrow-right text-success' : ' fa-arrow-left text-danger';
    }
}
<?php

namespace App\Models;

use Carbon\Carbon;

class Event
{
    public $date;
    public $value;
    public $name;

    public function __construct($date, $value, $name = "")
    {
        $this->date = Carbon::parse($date);;
        $this->value = $value;
        $this->name = $name;
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
<?php

namespace App\Interfaces;

/**
* The interface for converting and object to an event
*/
interface Eventable
{
    public function getEvent();
}
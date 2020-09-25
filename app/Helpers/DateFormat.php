<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateFormat
{
    public static function front($date)
    {
        if($date){
            return Carbon::parse($date)->format('d.m.Y H:i');
        }

        return '';
    }
}

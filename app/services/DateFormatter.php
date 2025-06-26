<?php

namespace App\Services;

class DateFormatter
{
    public function format($date, $format = 'd/m/Y')
    {
        if (empty($date)) {
            return null;
        }
        return date($format, strtotime($date));
    }
}
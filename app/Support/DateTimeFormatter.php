<?php

namespace App\Support;

use Carbon\Carbon;

class DateTimeFormatter
{
    public static function time12Hour($time): string
    {
        if (blank($time)) {
            return 'Time not provided';
        }

        return Carbon::parse($time)->format('g:i A');
    }

    public static function dateWithTime($dateTime): string
    {
        if (blank($dateTime)) {
            return 'Not provided';
        }

        return Carbon::parse($dateTime)->format('M d, Y g:i A');
    }

    public static function dateOnly($date): string
    {
        if (blank($date)) {
            return 'Date not provided';
        }

        return Carbon::parse($date)->format('M d, Y');
    }
}
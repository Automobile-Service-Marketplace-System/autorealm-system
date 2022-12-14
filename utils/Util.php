<?php

namespace app\utils;

class Util
{
    public static function isRealDate(string $date): bool
    {
        if (false === strtotime($date)) {
            return false;
        }
        [$year, $month, $day] = explode(separator: '-', string: $date);
        return checkdate($month, $day, $year);
    }
}

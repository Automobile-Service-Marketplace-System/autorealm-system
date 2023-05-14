<?php

namespace app\utils;

class Validation
{
    static public function isPositiveInteger(mixed $value): bool
    {
        $parsed_value = filter_var($value, FILTER_VALIDATE_INT);
        return $parsed_value !== false && $parsed_value > 0;
    }


    static public function isNonNegativeInteger(mixed $value): bool
    {
        return self::isPositiveInteger($value) || $value == 0;
    }

    static public function isNegativeInteger(mixed $value): bool
    {
        $parsed_value = filter_var($value, FILTER_VALIDATE_INT);
        return $parsed_value && !self::isPositiveInteger($value) && is_int($value);
    }


    static public function isPositiveNumber(mixed $value): bool
    {
        // check for all numeric values
        if (is_numeric($value)) {
            // check for positive values
            if ($value > 0) {
                return true;
            }
        }
        return false;
    }

    static public function isNonNegativeNumber(mixed $value): bool
    {
        return self::isPositiveNumber($value) || $value == 0;
    }

    static public function isNegativeNumber(mixed $value): bool
    {
        return !self::isPositiveNumber($value) && is_numeric($value);
    }
}
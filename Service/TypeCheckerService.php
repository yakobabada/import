<?php

class TypeCheckerService
{
    /**
     * @param $value
     * @return bool
     */
    public static function isInt($value): bool
    {
        if (1 === preg_match('/[0-9]+/', $value, $match)) {
            return true;
        }

        return false;
    }

    /**
     * @param $value
     * @return bool
     */
    public static function isString($value): bool
    {
        return is_string($value);
    }

    /**
     * @param $value
     *
     * @return bool
     */
    public static function isFloat($value): bool
    {
        if (1 === preg_match('/[0-9]+\.[0-9]*/', $value)) {
            return true;
        }

        return false;
    }
}
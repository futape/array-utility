<?php


namespace Futape\Utility\ArrayUtility;


abstract class Arrays
{
    /**
     * Compare values strictly
     *
     * @var int
     */
    const UNIQUE_STRICT = 1 << 8;

    /**
     * Convert array items to strings and compare as strings
     *
     * @var int
     */
    const UNIQUE_STRING = 1 << 9;

    /**
     * Ignore case when comparing strings.
     *
     * Only relevant if `self::UNIQUE_STRING` is active.
     *
     * @var int
     */
    const UNIQUE_IGNORE_CASE = 1 << 10;

    /**
     * Ignore case by converting all strings to lowercase.
     *
     * Only relevant if `self::UNIQUE_STRING` is active.
     *
     * @var int
     */
    const UNIQUE_LOWERCASE = 1 << 11;

    /**
     * @param array $value
     * @param bool $withKeys
     * @return array
     */
    public static function flatten(array $value, bool $withKeys = false): array
    {
        $flattened = [];

        foreach ($value as $key => $val) {
            if (is_array($val)) {
                if ($withKeys) {
                    $flattened[] = $key;
                }
                array_splice($flattened, count($flattened), 0, self::flatten($val, $withKeys));
            } else {
                $flattened[] = $val;
            }
        }

        return $flattened;
    }

    /**
     * Makes an array contain unique values only
     *
     * When duplicates are found, the first one is kept.
     * Unlike `array_unique()` this function doesn't preserve keys and returns an indexed array instead.
     * See documentation on `self::UNIQUE_*` constants for more information.
     * If non of these constants' values is contained in the passed bitmask, it is forwarded to PHP's `array_unique()`
     * function.
     *
     * @param array $value
     * @param int $options A bitmask of `self::UNIQUE_*` constants or `SORT_*` constants passed to `array_unique()`
     * @return array
     */
    public static function unique(array $value, int $options = self::UNIQUE_STRING | self::UNIQUE_IGNORE_CASE): array
    {
        switch (true) {
            case ($options & self::UNIQUE_STRICT):
                $unique = [];

                foreach ($value as $val) {
                    if (!in_array($val, $unique, true)) {
                        $unique[] = $val;
                    }
                }

                return $unique;

            case ($options & self::UNIQUE_STRING):
                array_walk(
                    $value,
                    function (&$val) {
                        $val = (string)$val;
                    }
                );

                if ($options & self::UNIQUE_LOWERCASE) {
                    return array_values(array_unique(array_map('mb_strtolower', $value)));
                }

                if ($options & self::UNIQUE_IGNORE_CASE) {
                    $unique = [];

                    foreach ($value as $val) {
                        if (!isset($unique[mb_strtolower($val)])) {
                            $unique[mb_strtolower($val)] = $val;
                        }
                    }

                    return array_values($unique);
                }

                return array_values(array_unique($value));

            default:
                return array_values(array_unique($value, $options));
        }
    }
}

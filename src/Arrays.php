<?php


namespace Futape\Utility\ArrayUtility;


abstract class Arrays
{
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
     * Makes an array of strings contain unique values only (case-insensitive)
     *
     * The first occurrence of a string is kept.
     *
     * @param string[] $value
     * @param bool $lowercase If set to true, all strings get lowercased
     * @return string[]
     */
    public static function unique(array $value, bool $lowercase = false): array
    {
        if ($lowercase) {
            $unique = array_unique(array_map('mb_strtolower', $value));
        } else {
            $unique = [];

            foreach ($value as $val) {
                if (!isset($unique[mb_strtolower($val)])) {
                    $unique[mb_strtolower($val)] = $val;
                }
            }
        }

        return array_values($unique);
    }
}

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
}

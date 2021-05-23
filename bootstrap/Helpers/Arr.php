<?php

namespace Bootstrap\Helpers;

trait Arr
{
    /**
     * @param $element
     * @param array $where
     * @return int
     */
    protected function push($element, array &$where = []): int
    {
        return array_push($where, $element);
    }

    /**
     * @param array $array
     * @param null $delimiter
     */
    protected function delimit(array &$array, $delimiter = null)
    {
        array_walk($array, function(&$value) use ($delimiter) {
            $value = $delimiter ? $delimiter . $value . $delimiter : $value;
        });
    }

    /**
     * @param string $separator
     * @param string $subject
     * @return false|string[]
     */
    protected function explode(string $separator, string $subject)
    {
        return explode($separator, $subject);
    }

    /**
     * @param array $array
     * @return mixed|null
     */
    protected function shift(array &$array)
    {
        return array_shift($array);
    }

    /**
     * @param array $flipping
     * @param null $needle
     * @return int|int[]|string|string[]
     */
    protected function flip(array $flipping, $needle = null)
    {
        $flippedData = array_flip($flipping);

        return $needle ? $flippedData[$needle] : $flippedData;
    }

    /**
     * @param string $key
     * @param array $array
     * @return bool
     */
    protected function keyExists(string $key, array $array): bool
    {
        return array_key_exists($key, $array);
    }

    /**
     * @param array $target
     * @param $notation
     * @param $end_value
     * @param string $separator
     */
    public static function setNest(array &$target, $notation, $end_value, string $separator = ".")
    {
        foreach (explode($separator, $notation) as $dot_notation_value) {
            $target = &$target[$dot_notation_value];
        }
        $target = $end_value;
    }

    /**
     * @param array $target
     * @param $notation
     * @param string $separator
     * @return mixed|string
     */
    public static function getNest(array $target, $notation, string $separator = ".")
    {
        $end_value = '';
        foreach(explode($separator, $notation) as $dot_notation_value) {
            if (is_array($end_value))
                $end_value = $end_value[$dot_notation_value];
            else
                $end_value = $target[$dot_notation_value];
        }
        return $end_value;
    }
}
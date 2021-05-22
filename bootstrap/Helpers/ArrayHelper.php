<?php

namespace Bootstrap\Helpers;

trait ArrayHelper
{
    protected function push($element, array &$where = [])
    {
        return array_push($where, $element);
    }

    protected function delimit(array &$array, $delimiter = null)
    {
        array_walk($array, function(&$value) use ($delimiter) {
            $value = $delimiter ? $delimiter . $value . $delimiter : $value;
        });
    }

    protected function explode(string $separator, string $subject)
    {
        return explode($separator, $subject);
    }

    protected function shift(array &$array)
    {
        return array_shift($array);
    }

    protected function flip(array $flipping, $needle = null)
    {
        $flippedData = array_flip($flipping);

        return $needle ? $flippedData[$needle] : $flippedData;
    }

    protected function keyExists(string $key, array $array)
    {
        return array_key_exists($key, $array);
    }

    public static function dotSet(array &$target, $notation, $end_value)
    {
        $dot_notation_array = explode(".", $notation);
        foreach ($dot_notation_array as $dot_notation_value) {
            $target = &$target[$dot_notation_value];
        }
        $last_key = array_key_last($target);
        $target = $end_value;
    }
}
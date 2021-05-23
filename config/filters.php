<?php

if (!function_exists('required')) {
    function required($value) {
        if ($value === null || strlen($value) < 1 || empty($value))
            return false;
        return $value;
    }
}
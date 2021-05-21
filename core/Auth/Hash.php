<?php

namespace Core\Auth;

use Core\Session\Session;
use Exception;

class Hash
{
    /**
     * @param $hashable
     * @return false|string
     */
    public static function make($hashable)
    {
        return password_hash($hashable, PASSWORD_BCRYPT);
    }

    /**
     * @param string $hashed_value
     * @param $unhashed_value
     * @return bool
     */
    public static function check(string $hashed_value, $unhashed_value, $token = false): bool
    {
        return $token ? password_verify($unhashed_value, $hashed_value) :
            hash_equals($hashed_value, $unhashed_value);
    }

    /**
     * @throws Exception
     */
    public static function token(): string
    {
        $token = bin2hex(random_bytes(16));
        Session::put('_token', $token);
        return $token;
    }
}
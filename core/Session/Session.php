<?php

namespace Core\Session;

class Session
{
    /**
     * @return bool
     */
    public static function start($name = 'tuts'): bool
    {
        session_name($name);
        return session_start();
    }

    public static function put(string $key, $value)
    {
        if (empty(static::id()))
            static::start();
        self::set($key, $value);
    }

    public static function get(string $key, $default = "")
    {
        return self::get_sess($key);
    }

    /**
     * @param string $key
     * @param $value
     */
    public static function set(string $key, $value): array
    {
        if (empty(static::id()))
            static::start();

        $_SESSION[$key] = $value;
        return $_SESSION;
    }

    /**
     * @param string $key
     * @param $value
     * @return array
     */
    public static function get_sess(string $key, $default = "")
    {
        if (empty(static::id()))
            static::start();

        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = $default;
            return $_SESSION[$key];
        }
        return $_SESSION[$key];
    }

    /**
     * @return int
     */
    public static function id()
    {
        return session_id();
    }

    public static function name($name = null)
    {
        if (!is_null($name)) {
            session_name($name);
            return session_name();
        }
        return session_name();
    }

    public static function has($key): bool
    {
        if (empty(session_id())) {
            static::start();
        }
        return isset($_SESSION[$key]);
    }
}
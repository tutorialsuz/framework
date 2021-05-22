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

    public static function put($key, $value = null): array
    {
        if (empty(static::id()))
            static::start();

        if (is_array($key) && $value === null) {
            foreach ($key as $s_key => $s_val) {
                self::set($s_key, $s_val);
            }
            return self::set();
        }
        return self::set($key, $value);
    }

    public static function &get(string $key, $default = "")
    {
        $session = self::get_sess($key);
        return $session;
    }

    /**
     * @param string|null $key
     * @param $value
     * @return array
     */
    public static function set(string $key = null, $value = null): array
    {
        if (empty(static::id()))
            static::start();

        if ($value !== null)
            $_SESSION[$key] = $value;
        return $_SESSION;
    }

    /**
     * @param string $key
     * @param string $default
     * @return string|array
     */
    public static function get_sess(string $key, string $default = "")
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

    public static function all(): array
    {
        if (empty(session_id()))
            static::start();

        if (array_key_exists("tuts_flash_mess_container", $_SESSION))
            unset($_SESSION['tuts_flash_mess_container']);
        return $_SESSION;
    }

    public static function delete($key)
    {
        if (empty(session_id()))
            static::start();

        unset($_SESSION[$key]);
    }

    public static function destroy(): bool
    {
        if (empty(session_id()))
            static::start();

        return session_destroy();
    }
}
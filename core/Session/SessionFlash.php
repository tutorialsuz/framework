<?php

namespace Core\Session;

class SessionFlash
{
    /**
     * @param $key
     * @param null $value
     * @return array
     */
    public static function set($key, $value = null): array
    {
        if (is_array($key))
            return Session::put('tuts_flash_mess_container', $key);

        if ($value === null) return [];

        return Session::put('tuts_flash_mess_container', $key);
    }

    public static function get($key)
    {
        if (!Session::has('tuts_flash_mess_container'))
            return null;

        $flash = Session::get('tuts_flash_mess_container');
        if (count(Session::get('tuts_flash_mess_container')) === 0)
            Session::delete('tuts_flash_mess_container');
        else
            static::delete($key);
        return $flash[$key];
    }

    public static function delete($key)
    {
        $flash_container = &$_SESSION['tuts_flash_mess_container'];
        unset($flash_container[$key]);
    }
}
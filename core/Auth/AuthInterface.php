<?php

namespace Core\Auth;

use App\Models\Model;

interface AuthInterface
{
    /**
     * @param array $credentials
     * @return mixed
     */
    public static function attempt(array $credentials);

    /**
     * @param int $id
     * @return mixed
     */
    public static function loginById(int $id);

    /**
     * @param array $credentials
     * @return mixed
     */
    public static function login(array $credentials);

    /**
     * @return mixed
     */
    public static function logout();

    /**
     * @param string $guard
     * @return mixed
     */
    public static function guard(string $guard = "web");
}
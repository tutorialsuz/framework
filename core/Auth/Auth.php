<?php

namespace Core\Auth;

use App\Models\Model;
use Core\Session\Session;

class Auth implements AuthInterface
{
    public static $guard;

    public static function attempt(array $credentials): array
    {
        if (isset($credentials['password'])) {
            $credentials["password"] = Hash::make($credentials['password']);
        }
        return $credentials; // temporary
    }

    public static function loginById(int $id)
    {
        // TODO: Implement loginById() method.
    }

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public static function login(array $credentials)
    {
        $model = self::models(['email' => $credentials['email']]);
        $true = $model !== false && property_exists($model, "name");

        $pwd = $credentials['name'];
        $hash = $model->name;

        if ($true && self::verifyPassword($pwd, $hash))
            self::setSession($model->id);
    }

    public static function logout()
    {
        self::deleteSession();
    }

    /**
     * @param string $guard
     * @return Auth
     */
    public static function guard(string $guard = "web"): Auth
    {
        self::$guard = provider(guard($guard . ".provider"));
        return new self();
    }

    public static function user()
    {
        $model = self::$guard::where(['id' => 7])->get();
    }

    public static function models(array $condition, $group = "first")
    {
        if (self::$guard === null)
            self::guard();

        return self::$guard::where($condition)->{$group}();
    }

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public static function verifyPassword($password, $hash)
    {
        if (password_verify($password, $hash))
            return true;

        self::deleteSession();

        return request()->back()->with([
            "error" => "Email/password doesn't match. Try again"
        ]);
    }

    /**
     * @param int $id
     */
    public static function setSession(int $id)
    {
        Session::set("loggedin", true);
        Session::set("userid", $id);
    }

    /**
     * @return bool
     */
    public static function deleteSession(): bool
    {
        if (Session::has('loggedin') && Session::has('userid')) {
            Session::delete("loggedin");
            Session::delete("userid");
            return true;
        }

        return false;
    }
}
<?php


namespace Bootstrap\Requests;


use Core\Auth\Hash;
use Core\Exceptions\CsrfException;
use Core\Session\Session;

class Request
{
    /**
     * @return mixed
     */
    public function getUserAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    /**
     * @return mixed
     */
    public function getUri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * @param string $route
     * @return bool
     */
    public function isCurrentRoute(string $route): bool
    {
        return trim($this->getUri(), "/") === $route;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @param $key
     * @return string|null
     */
    public function input($key): ?string
    {
        return $this->all($key);
    }

    /**
     * @return array|string
     */
    public function all($key = null)
    {
        return $key ? $_REQUEST[$key] : $_REQUEST;
    }

    public function setMethod(string $method)
    {
        $_SERVER['REQUEST_METHOD'] = $method;
    }

    /**
     * @param string $method
     * @return bool
     * @throws CsrfException
     */
    public function isMethod(string $method): bool
    {
        if ($this->getMethod() !== "GET" && !$this->hasCsrfToken())
            throw new CsrfException("CSRF attack detected");

        if (isset($this->all()['_method'])) {
            $this->setMethod($this->all()['_method']);
            return true;
        }

        // if there is no csrf token and is GET Method let the request pass into app
        if ($this->getMethod() === strtoupper($method)) {
            $this->setMethod($method);
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function hasCsrfToken(): bool
    {
        $user_token = $_REQUEST["_token"];
        $system_token = Session::get("_token");

        return isset($_REQUEST["_token"]) &&
            Session::has("_token") &&
            Hash::check($system_token, $user_token, false);
    }
}
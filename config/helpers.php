<?php

use Bootstrap\Helpers\Arr;
use Core\Auth\Hash;
use Core\Session\Session;
use Core\Session\SessionFlash;
use DI\DependencyException;
use DI\NotFoundException;

if (!function_exists('commands')) {
    function commands() {
        return require __DIR__ . '/commands.php';
    }
}

if (!function_exists('app')) {
    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    function app($key = null) {
        if (!is_null($key))
            return dependencyInjector()->get($key);
        return dependencyInjector()->get('Application');
    }
}

if (!function_exists('request')) {
    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    function request() {
        return dependencyInjector()->get('request');
    }
}

if (!function_exists('view')) {
    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    function view(string $view, array $data = [], $layout = 'app') {
        $viewClass = dependencyInjector()->get('View');
        $viewClass->setLayout($layout);
        try {
            return $viewClass->render($view, $data);
        } catch (Exception $exception) {
            die($exception->getMessage());
        }
    }
}

if (!function_exists('str_ends_with')) {
    function str_ends_with($needle, $string): bool
    {
        return substr($string, -1) === $needle;
    }
}

/**
 * @throws Exception
 */
if (!function_exists('csrf_method')) {
    function csrf_token() {
        echo '<input type="hidden" name="_token" value="' . Hash::token() . '">';
    }
}

if (!function_exists('method')) {
    function method($name) {
        echo '<input type="hidden" name="_method" value="' . $name . '">';
    }
}

if (!function_exists('flash')) {
    function flash($key) {
        return SessionFlash::get($key);
    }
}

if (!function_exists('session')) {
    function session($key, $value = null) {
        if ($value === null)
            return Session::get($key);
        return Session::put($key, $value);
    }
}

if (!function_exists('auth_config')) {
    function auth_config($target) {
        return Arr::getNest(cinclude('auth'), $target);
    }
}

if (!function_exists('guard')) {
    function guard($guard) {
        return Arr::getNest(cinclude('auth'), "guards.{$guard}");
    }
}

if (!function_exists('provider')) {
    function provider($provider) {
        return Arr::getNest(cinclude('auth'), "providers.{$provider}");
    }
}

// config include = cinclude
if (!function_exists('cinclude')) {
    function cinclude($target) {
        return include "{$target}.php";
    }
}

if (!function_exists('asset')) {

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */

    function asset($asset): string
    {
        return baseurl() . DIRECTORY_SEPARATOR . $asset;
    }
}

if (!function_exists('baseurl')) {

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    function baseurl($full = false) {
        $base = request()->getBaseUrl();
        $rest = request()->getUri();
        return $full ? $base . $rest : $base;
    }
}


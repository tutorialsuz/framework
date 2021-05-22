<?php

use Core\Auth\Hash;
use Core\Session\Session;
use Core\Session\SessionFlash;

if (!function_exists('commands')) {
    function commands() {
        return require __DIR__ . '/commands.php';
    }
}

if (!function_exists('app')) {
    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    function app() {
        return dependencyInjector()->get('Application');
    }
}

if (!function_exists('request')) {
    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    function request() {
        return dependencyInjector()->get('request');
    }
}

if (!function_exists('view')) {
    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
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

        if (is_array($key)) {
            foreach (array_keys($key) as $session) {
                Session::put($session, $key[$session]);
            }
            return true;
        }

        return Session::put($key, $value);
    }
}
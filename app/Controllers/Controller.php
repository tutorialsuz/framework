<?php


namespace App\Controllers;

use Bootstrap\UrlManager;

class Controller extends UrlManager
{
    protected function dispatch(callable $callable, array $params)
    {
        return call_user_func_array($callable, $params['data']);
    }
}
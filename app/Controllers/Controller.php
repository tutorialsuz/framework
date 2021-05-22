<?php

namespace App\Controllers;

use Bootstrap\UrlManager;
use function request;

class Controller extends UrlManager
{
    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    protected function dispatch(callable $callable, array $params)
    {
        array_push($params['data'], request());
        return call_user_func_array($callable, $params['data']);
    }
}
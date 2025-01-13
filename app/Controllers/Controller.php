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
        $data = isset($params['data']) ? array_values($params['data']) : [];
        return call_user_func_array($callable, $data);
    }
}

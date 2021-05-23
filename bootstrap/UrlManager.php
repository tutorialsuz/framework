<?php


namespace Bootstrap;

use Bootstrap\Helpers\Arr;
use Bootstrap\Requests\Request;

class UrlManager extends Request
{
    use Arr;

    protected function is($route): bool
    {
        return trim($route) === basename(request()->getUri());
    }
}

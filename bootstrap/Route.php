<?php


namespace Bootstrap;

use App\Controllers\Controller;
use Core\Exceptions\BadMethodException;
use Core\Exceptions\CsrfException;
use DI\NotFoundException;

class Route extends Controller
{
    /**
     * @var
     */
    private $route;

    /**
     * @param $url
     * @param $controller
     */
    public function get($url, $controller)
    {
        if (preg_match($this->pattern($url), $this->getUri(), $data)) {
            try {
                $this->set($url, $controller, $this->wildcards($data));
            } catch (BadMethodException $badMethodException) {
                die($badMethodException->getMessage());
            }
        }
    }

    public function post($url, $controller)
    {
        if (preg_match($this->pattern($url), $this->getUri(), $data)) {
            try {
                $this->set($url, $controller, $this->wildcards($data));
            } catch (BadMethodException $badMethodException) {
                die($badMethodException->getMessage());
            }
        }
    }

    public function put($url, $controller)
    {
        if (preg_match($this->pattern($url), $this->getUri(), $data)) {
            try {
                $this->set($url, $controller, $this->wildcards($data));
            } catch (BadMethodException $badMethodException) {
                die($badMethodException->getMessage());
            }
        }
    }

    public function patch($url, $controller)
    {
        if (preg_match($this->pattern($url), $this->getUri(), $data)) {
            try {
                $this->set($url, $controller, $this->wildcards($data));
            } catch (BadMethodException $badMethodException) {
                die($badMethodException->getMessage());
            }
        }
    }

    public function delete($url, $controller)
    {
        if (preg_match($this->pattern($url), $this->getUri(), $data)) {
            try {
                $this->set($url, $controller, $this->wildcards($data));
            } catch (BadMethodException $badMethodException) {
                die($badMethodException->getMessage());
            }
        }
    }

    /**
     * @throws NotFoundException
     */
    private function discoverRoute()
    {
        if (is_null($this->route['url']))
            throw new NotFoundException(sprintf(
                    "The requested route <b>%s</b> is not found on server", $this->getUri())
            );

        if (isset($this->route['controller']))
            $this->dispatch($this->route['controller'], $this->route);
    }

    /**
     * @param $url
     * @return string
     */
    private function pattern($url): string
    {
        return "#^/?" . preg_replace("#/{([^/]+)}#", "/(?<$1>[^/]+)", $url) . "/?$#";
    }

    /**
     * @param array $data
     * @return array
     */
    private function wildcards(array $data): array
    {
        $result = [];
        foreach ($data as $key => $value) {
            if (!is_int($key)) $result[$key] = $value;
        }
        return $result;
    }

    /**
     * @throws BadMethodException
     */
    private function set($url, $controller, $data)
    {
        $called_method = debug_backtrace()[1]['function'];
        $this->route['url'] = $url;
        try {
            if ($this->isCurrentRoute($url) && !$this->isMethod($called_method))
                throw new BadMethodException("This method is not acceptable for this route");

            if (isset($this->all()['_method']) && ($called_method !== strtolower($this->all()['_method']))) {
                throw new BadMethodException("This method is not acceptable for this route");
            }
        } catch (CsrfException $csrfException) {
            die($csrfException->getMessage());
        }
        $this->route['data'] = $data;
        $this->route['controller'] = $controller;
    }

    public function __destruct()
    {
        try {
            $this->discoverRoute();
        } catch (NotFoundException $notFoundException) {
            die($notFoundException->getMessage());
        }
    }
}
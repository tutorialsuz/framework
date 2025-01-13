<?php

namespace Tests\Unit\Routes;

use PHPUnit\Framework\TestCase;

class UserRouteTest extends TestCase
{
    private $routeCallback;

    protected function setUp(): void
    {
        parent::setUp();
        // Get the route callback from web.php
        $route = require __DIR__ . '/../../../routes/web.php';
        $routes = $route->getRoutes();
        foreach ($routes as $r) {
            if ($r['uri'] === 'user/{id}') {
                $this->routeCallback = $r['callback'];
                break;
            }
        }
    }

    public function testRejectsNonNumericId()
    {
        ob_start();
        $response = call_user_func($this->routeCallback, 'abc');
        ob_end_clean();

        $this->assertEquals('Invalid user ID', $response);
    }

    public function testAcceptsAndEscapesNumericId()
    {
        ob_start();
        call_user_func($this->routeCallback, '123');
        $output = ob_get_clean();

        $this->assertEquals('123', $output);
    }

    public function testEscapesSpecialCharacters()
    {
        ob_start();
        call_user_func($this->routeCallback, '123<script>');
        $output = ob_get_clean();

        $this->assertEquals('123&lt;script&gt;', $output);
    }
}
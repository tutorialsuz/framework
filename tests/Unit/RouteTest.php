<?php

namespace Tests\Unit;

use Bootstrap\Route;
use Core\Exceptions\BadMethodException;
use DI\NotFoundException;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    private Route $route;

    protected function setUp(): void
    {
        parent::setUp();
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_REQUEST = [];
        $this->route = dependencyInjector()->get('Router');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($_SERVER['REQUEST_URI']);
        unset($_SERVER['REQUEST_METHOD']);
        $_REQUEST = [];
    }

    public function testBasicRouteMatching()
    {
        $_SERVER['REQUEST_URI'] = '/users/create';
        
        $called = false;
        $this->route->get('/users/create', function() use (&$called) {
            $called = true;
        });
        
        $this->assertTrue($called, 'Route handler should be called for exact match');
    }

    public function testWildcardRouteMatching()
    {
        $_SERVER['REQUEST_URI'] = '/user/123';
        
        $capturedId = null;
        $this->route->get('/user/{id}', function($id) use (&$capturedId) {
            $capturedId = $id;
        });
        
        $this->assertEquals('123', $capturedId, 'Wildcard parameter should be captured');
    }

    public function testMethodNotAllowed()
    {
        $_SERVER['REQUEST_URI'] = '/users';
        $_SERVER['REQUEST_METHOD'] = 'POST';
        
        $this->expectException(BadMethodException::class);
        
        $this->route->get('/users', function() {
            return true;
        });
    }

    public function testMultipleWildcards()
    {
        $_SERVER['REQUEST_URI'] = '/users/123/posts/456';
        
        $capturedParams = [];
        $this->route->get('/users/{userId}/posts/{postId}', function($userId, $postId) use (&$capturedParams) {
            $capturedParams['userId'] = $userId;
            $capturedParams['postId'] = $postId;
        });
        
        $this->assertEquals(
            ['userId' => '123', 'postId' => '456'],
            $capturedParams,
            'Multiple wildcard parameters should be captured'
        );
    }

    public function testTrailingSlashes()
    {
        $_SERVER['REQUEST_URI'] = '/users/';
        
        $called = false;
        $this->route->get('/users', function() use (&$called) {
            $called = true;
        });
        
        $this->assertTrue($called, 'Route should match regardless of trailing slash');
    }

    public function testRouteNotFound()
    {
        $_SERVER['REQUEST_URI'] = '/non-existent';
        
        $this->expectException(NotFoundException::class);
        
        $this->route->get('/different-route', function() {
            return true;
        });
        
        $this->route->__destruct();
    }
}

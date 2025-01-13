<?php

namespace Tests\Unit\Controllers;

use App\Controllers\HomeController;
use Bootstrap\Requests\Request;
use Core\Session\Session;
use PHPUnit\Framework\TestCase;

class HomeControllerTest extends TestCase
{
    private $controller;
    private $request;
    private $session;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new HomeController();
        $this->request = $this->createMock(Request::class);
        $this->session = $this->createMock(Session::class);
    }

    public function testStoreRejectsInvalidCSRFToken()
    {
        $this->request->expects($this->once())
            ->method('input')
            ->with('_token')
            ->willReturn('invalid_token');

        Session::expects($this->once())
            ->method('verifyToken')
            ->with('invalid_token')
            ->willReturn(false);

        ob_start();
        $response = $this->controller->store($this->request);
        ob_end_clean();

        $this->assertEquals('Invalid CSRF token', $response);
    }

    public function testStoreValidatesEmailFormat()
    {
        $this->request->expects($this->once())
            ->method('input')
            ->with('_token')
            ->willReturn('valid_token');

        Session::expects($this->once())
            ->method('verifyToken')
            ->with('valid_token')
            ->willReturn(true);

        $this->request->expects($this->once())
            ->method('validate')
            ->with([
                'email' => 'required|email|max:255',
                'phone' => 'required|regex:/^[0-9]{10,15}$/'
            ])
            ->willReturn([
                'email' => 'test@example.com',
                'phone' => '1234567890'
            ]);

        ob_start();
        $this->controller->store($this->request);
        $output = ob_get_clean();

        $this->assertStringContainsString('Email: test@example.com', $output);
        $this->assertStringContainsString('Phone: 1234567890', $output);
    }
}
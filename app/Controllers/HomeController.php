<?php

namespace App\Controllers;

use Bootstrap\Requests\Request;
use Core\Auth\Auth;
use Core\Session\Session;

class HomeController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * @return mixed
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function create()
    {
        return view('user/create');
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        // Verify CSRF token
        if (!Session::verifyToken($request->input('_token'))) {
            http_response_code(403);
            return 'Invalid CSRF token';
        }

        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'phone' => 'required|regex:/^[0-9]{10,15}$/' // Validates phone numbers between 10-15 digits
        ]);

        // Sanitize and escape output
        $safeEmail = htmlspecialchars($validated['email'], ENT_QUOTES, 'UTF-8');
        $safePhone = htmlspecialchars($validated['phone'], ENT_QUOTES, 'UTF-8');
        
        echo "Email: {$safeEmail} | Phone: {$safePhone}";
    }
}

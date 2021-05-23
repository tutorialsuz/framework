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
        $validated = $request->validate([
            'email' => 'required',
            'phone' => 'integer'
        ]);

        echo "Email: {$validated['email']} | Phone: {$validated['phone']}";
    }
}

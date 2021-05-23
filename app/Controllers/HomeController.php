<?php

namespace App\Controllers;

use Bootstrap\Requests\Helpers\Filter;
use Bootstrap\Requests\Request;

class HomeController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        return view('welcome');
    }

    public function create()
    {
        return view('user/create');
    }

    public function store(Request $request)
    {
        $validated = Filter::validate([
            'email' => 'required',
            'phone' => 'integer'
        ]);

        echo "Email: {$validated['email']} | Phone: {$validated['phone']}";
    }
}

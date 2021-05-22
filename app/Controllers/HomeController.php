<?php

namespace App\Controllers;

use App\Models\User;
use Bootstrap\Requests\Helpers\Filter;
use Bootstrap\Requests\Helpers\FilterTrait;
use Bootstrap\Requests\Request;
use Core\Session\Session;
use Core\Session\SessionFlash;
use Exception;
use GuzzleHttp\Client;

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
            'email' => 'email',
            'phone' => 'integer'
        ]);

        echo "validated page";
    }
}

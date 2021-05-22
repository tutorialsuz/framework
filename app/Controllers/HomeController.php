<?php

namespace App\Controllers;

use App\Models\User;
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
}

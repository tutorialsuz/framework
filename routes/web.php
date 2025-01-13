<?php

use App\Controllers\HomeController;

$route->get('/', [HomeController::class, 'index']);

// Route with wildcards
$route->get('user/{id}', function($id) {
    echo $id;
});

$route->get('users/create', [HomeController::class, 'create']);
$route->post('users', [HomeController::class, 'store']);

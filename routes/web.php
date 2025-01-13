<?php

use App\Controllers\HomeController;

$route->get('/', [HomeController::class, 'index']);

// Route with wildcards
$route->get('user/{id}', function($id) {
    // Validate id is numeric and escape output
    if (!is_numeric($id)) {
        http_response_code(400);
        return 'Invalid user ID';
    }
    echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8');
});

$route->get('users/create', [HomeController::class, 'create']);
$route->post('users', [HomeController::class, 'store']);

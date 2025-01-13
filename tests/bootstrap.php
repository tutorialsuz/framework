<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Define test environment
define('PHPUNIT_RUNNING', true);

// Set up container
$container = new \DI\Container();

// Register test services
$container->set('request', function() {
    return new \Bootstrap\Requests\Request();
});

$container->set('Router', function() use ($container) {
    return new \Bootstrap\Route();
});

// Set global container
if (!function_exists('dependencyInjector')) {
    function dependencyInjector() {
        global $container;
        return $container;
    }
}

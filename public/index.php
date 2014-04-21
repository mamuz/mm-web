<?php

if (file_exists('environment.php')) {
    require 'environment.php';
}

// Define environment
$env = getenv('APPLICATION_ENV') ? : 'production';

/**
 * Display all errors when environment is development.
 * Define request consts for Zend developer tools.
 */
if ($env === 'development') {
    define('REQUEST_MEMORY_USAGE', memory_get_usage());
    define('REQUEST_MICROTIME', microtime(true));
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

// Setup autoloading
require 'init_autoloader.php';

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();

<?php

define('__INDEX_INCLUDED', true);

if (file_exists('environment.php')) {
    require 'environment.php';
}

chdir(getenv('APPLICATION_PATH') ? : dirname(__DIR__));

require 'init_autoloader.php';

Zend\Mvc\Application::init(require 'config/application.config.php')->run();

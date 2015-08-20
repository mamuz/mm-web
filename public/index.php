<?php

chdir(getenv('APPLICATION_PATH') ?: dirname(__DIR__));

include './environment.php';
include './vendor/autoload.php';

Zend\Mvc\Application::init(require './config/application.config.php')->run();

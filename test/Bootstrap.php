<?php

error_reporting(E_ALL);

if (function_exists('xdebug_disable')) {
    xdebug_disable();
}

$file = __DIR__ . '/../vendor/autoload.php';
if (file_exists($file)) {
    $loader = require $file;
}

if (!isset($loader)) {
    throw new \RuntimeException('Can not find vendor/autoload.php');
}

$modulePath = __DIR__ . '/../module';
$modules = array_diff(scandir($modulePath), array('.', '..'));
foreach ($modules as $module) {
    /** @var \Composer\Autoload\ClassLoader $loader */
    $loader->add($module . '\\', $modulePath . '/' . $module . '/src');
    $loader->add($module . 'Test\\', $modulePath . '/' . $module . '/test');
}

unset($file, $loader);

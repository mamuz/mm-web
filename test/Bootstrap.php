<?php

error_reporting(E_ALL);

if (version_compare(PHP_VERSION, '5.4', '>=') && gc_enabled()) {
    /**
     * Disabling Zend Garbage Collection to prevent segfaults with PHP5.4+
     *
     * @see https://bugs.php.net/bug.php?id=53976
     */
    gc_disable();
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

<?php

if (file_exists('environment.php')) {
    include 'environment.php';
}

if (file_exists('vendor/autoload.php')) {
    $loader = include 'vendor/autoload.php';
}

if (class_exists('Zend\Loader\AutoloaderFactory')) {
    return;
}

$zf2Path = false;
if (is_dir('vendor/ZF2/library')) {
    $zf2Path = 'vendor/ZF2/library';
} elseif (getenv('ZF2_PATH')) {
    $zf2Path = getenv('ZF2_PATH');
}

if ($zf2Path) {
    if (isset($loader)) {
        $loader->add('Zend', $zf2Path);
        $loader->add('ZendXml', $zf2Path);
    } else {
        include $zf2Path . '/Zend/Loader/AutoloaderFactory.php';
        Zend\Loader\AutoloaderFactory::factory(
            array(
                'Zend\Loader\ClassMapAutoloader' => array(
                    'Composer' => __DIR__ . '/vendor/composer/autoload_classmap.php',
                )
            )
        );
    }
}

if (!class_exists('Zend\Loader\AutoloaderFactory')) {
    throw new RuntimeException('Unable to load ZF2.');
}

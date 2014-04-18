<?php

$zf2Path = __DIR__ . '/vendor/zendframework/zendframework/library';

if (APPLICATION_ENV != 'production') {

    // Composer autoloading
    if (file_exists(__DIR__ . '/vendor/autoload.php')) {
        $loader = include __DIR__ . '/vendor/autoload.php';
    };

    if ($zf2Path) {
        if (isset($loader)) {
            $loader->add('Zend', $zf2Path);
        } else {
            include $zf2Path . '/Zend/Loader/AutoloaderFactory.php';
            Zend\Loader\AutoloaderFactory::factory(
                array(
                    'Zend\Loader\StandardAutoloader' => array(
                        'autoregister_zf' => true
                    )
                )
            );
        }
    }

} else {

    /**
     * @see Zend\Loader\AutoloaderFactory
     */
    require_once $zf2Path . '/Zend/Loader/AutoloaderFactory.php';

    /**
     * @see Zend\Loader\ClassMapAutoloader
     */
    require_once $zf2Path . '/Zend/Loader/ClassMapAutoloader.php';

    if (!class_exists('Zend\Loader\AutoloaderFactory')
        || !class_exists('Zend\Loader\ClassMapAutoloader')
    ) {
        throw new RuntimeException('Unable init autoloading. Run `php composer.phar install -o`');
    }

    Zend\Loader\AutoloaderFactory::factory(
        array(
            'Zend\Loader\ClassMapAutoloader' => array(
                'Composer' => __DIR__ . '/vendor/composer/autoload_classmap.php',
            )
        )
    );

}
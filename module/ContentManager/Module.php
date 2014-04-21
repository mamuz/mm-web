<?php

namespace ContentManager;

use Zend\ModuleManager\Feature;
use Zend\Mvc\ModuleRouteListener;

class Module implements
    Feature\AutoloaderProviderInterface,
    Feature\ConfigProviderInterface,
    Feature\DependencyIndicatorInterface
{
    public function getModuleDependencies()
    {
        return array(
            'DoctrineModule',
            'DoctrineORMModule',
            'MaglMarkdown',
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}

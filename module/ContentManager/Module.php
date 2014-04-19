<?php

namespace ContentManager;

use Zend\ModuleManager\Feature;
use Zend\Mvc\ModuleRouteListener;

class Module implements
    Feature\AutoloaderProviderInterface,
    Feature\ConfigProviderInterface
{
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

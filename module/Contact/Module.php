<?php

namespace Contact;

use Zend\ModuleManager\Feature;
use Zend\ModuleManager\ModuleManagerInterface;

class Module implements
    Feature\AutoloaderProviderInterface,
    Feature\ConfigProviderInterface,
    Feature\InitProviderInterface
{
    public function init(ModuleManagerInterface $modules)
    {
        $modules->loadModule('DoctrineModule');
        $modules->loadModule('DoctrineORMModule');
        $modules->loadModule('TwbBundle');
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

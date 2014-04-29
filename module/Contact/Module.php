<?php

namespace Contact;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature;
use Zend\ModuleManager\ModuleManagerInterface;
use Zend\Mvc\ApplicationInterface;

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

    public function onBootstrap(EventInterface $e)
    {
        /** @var ApplicationInterface $application */
        $application = $e->getTarget();
        $this->attachListenerTo($application);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * @param ApplicationInterface $application
     * @return void
     */
    private function attachListenerTo(ApplicationInterface $application)
    {
        $sm = $application->getServiceManager();
        $em = $application->getEventManager();

        /* @var \Contact\Listener\Aggregate $listenerAggregate */
        $listenerAggregate = $sm->get('Contact\Listener\Aggregate');
        $em->attachAggregate($listenerAggregate);
    }
}

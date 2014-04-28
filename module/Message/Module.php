<?php

namespace Message;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature;
use Zend\Mvc\ApplicationInterface;

class Module implements
    Feature\AutoloaderProviderInterface,
    Feature\BootstrapListenerInterface,
    Feature\ConfigProviderInterface
{
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

        /* @var \Message\Listener\Aggregate $listenerAggregate */
        $listenerAggregate = $sm->get('Message\Listener\Aggregate');
        $em->attachAggregate($listenerAggregate);
    }
}

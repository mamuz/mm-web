<?php

namespace Application;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature;
use Zend\Mvc\ModuleRouteListener;

class Module implements
    Feature\AutoloaderProviderInterface,
    Feature\BootstrapListenerInterface,
    Feature\ConfigProviderInterface
{
    public function onBootstrap(EventInterface $e)
    {
        /** @var \Zend\Mvc\MvcEvent $e */
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $response = $e->getResponse();
        if ($response instanceof \Zend\Http\Response) {
            $response->getHeaders()->addHeaderLine(
                'Content-Type',
                'text/html; charset=UTF-8'
            );
            $response->getHeaders()->addHeaderLine(
                'Content-Language',
                'en'
            );
        }
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

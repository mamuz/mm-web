<?php

namespace Application\Listener;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AggregateFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @return \Zend\EventManager\ListenerAggregateInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ServiceLocatorInterface $pluginManager */
        $pluginManager = $serviceLocator->get('Application\PluginManager');

        return new Aggregate($pluginManager);
    }
}

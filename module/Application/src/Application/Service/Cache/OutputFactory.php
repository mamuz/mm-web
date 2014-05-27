<?php

namespace Application\Service\Cache;

use Zend\Cache\StorageFactory;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class OutputFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @return OutputInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config')['application']['cache']['output'];

        $storage = StorageFactory::factory($config['storage']);

        $cacher = new OutputDecorator($storage);

        if (isset($config['blacklistedRouteNames'])) {
            $cacher->setBlacklistedRouteNames((array) $config['blacklistedRouteNames']);
        }

        return $cacher;
    }
}

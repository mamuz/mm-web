<?php

namespace Application\Service\Cache;

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
        $config = $serviceLocator->get('Config')['caches']['outputCache'];
        /** @var \Zend\Cache\Storage\StorageInterface $storage */
        $storage = $serviceLocator->get('outputCache');

        $cacher = new OutputDecorator($storage);

        if (isset($config['blacklistedRouteNames'])) {
            $cacher->setBlacklistedRouteNames((array) $config['blacklistedRouteNames']);
        }

        return $cacher;
    }
}

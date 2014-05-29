<?php

namespace MamuzApplication\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class OutputCacheFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @return \MamuzApplication\Service\Feature\OutputCacheInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config')['caches']['outputCache'];
        /** @var \Zend\Cache\Storage\StorageInterface $storage */
        $storage = $serviceLocator->get('outputCache');

        $cacher = new OutputCache($storage);

        if (isset($config['blacklistedRouteNames'])) {
            $cacher->setBlacklistedRouteNames((array) $config['blacklistedRouteNames']);
        }

        return $cacher;
    }
}

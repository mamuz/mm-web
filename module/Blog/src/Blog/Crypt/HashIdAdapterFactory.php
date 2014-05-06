<?php

namespace Blog\Crypt;

use Hashids\Hashids;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;

class HashIdAdapterFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @return ServiceLocatorInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config')['crypt']['hashid'];

        $hashIds = new HashIds(
            $config['sault'],
            $config['minLength'],
            $config['chars']
        );

        return new HashIdAdapter($hashIds);
    }
}

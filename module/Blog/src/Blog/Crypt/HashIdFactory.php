<?php

namespace Blog\Crypt;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;

class HashIdFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @return ServiceLocatorInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sault = $serviceLocator->get('Config')['crypt']['hashid']['sault'];
        return new HashId($sault);
    }
}

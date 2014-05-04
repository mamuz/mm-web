<?php

namespace Blog\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
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
        if ($serviceLocator instanceof ServiceLocatorAwareInterface) {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }
        /** @var ServiceLocatorInterface $domainManager */
        $domainManager = $serviceLocator->get('Blog\DomainManager');

        /** @var \Blog\Crypt\CryptInterface $cryptEngine */
        $cryptEngine = $domainManager->get('Blog\Crypt\HashId');

        return new HashId($cryptEngine);
    }
}

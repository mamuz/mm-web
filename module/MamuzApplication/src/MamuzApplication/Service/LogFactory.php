<?php

namespace MamuzApplication\Service;

use Zend\Log\Logger;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LogFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @return \Zend\Log\LoggerInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config')['mamuz-application']['log'];
        $logger = new Logger($config);

        return $logger;
    }
}

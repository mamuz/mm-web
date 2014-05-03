<?php

namespace Application\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ErrorHandlingFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @return \Application\Service\Feature\ExceptionLoggerInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ServiceLocatorInterface $pluginManager */
        $pluginManager = $serviceLocator->get('Application\PluginManager');
        /** @var \Zend\Log\LoggerInterface $logger */
        $logger = $pluginManager->get('Application\Service\Log');

        return new ErrorHandling($logger);
    }
}

<?php

namespace MamuzApplication\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ErrorHandlingFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @return \MamuzApplication\Service\Feature\ExceptionLoggerInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ServiceLocatorInterface $pluginManager */
        $pluginManager = $serviceLocator->get('MamuzApplication\PluginManager');
        /** @var \Zend\Log\LoggerInterface $logger */
        $logger = $pluginManager->get('MamuzApplication\Service\Log');

        return new ErrorHandling($logger);
    }
}

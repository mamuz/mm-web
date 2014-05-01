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
        /** @var \Zend\Log\LoggerInterface $logger */
        $logger = $serviceLocator->get('Application\Service\Log');

        return new ErrorHandling($logger);
    }
}

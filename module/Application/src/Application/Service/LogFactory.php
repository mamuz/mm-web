<?php

namespace Application\Service;

use Zend\Log\Logger;
use Zend\Log\LoggerInterface;
use Zend\Log\Writer\Stream;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LogFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @return LoggerInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $logger = new Logger;
        $logger->addWriter(
            new Stream('./data/logs/error_' . date('Y-m') . '.log')
        );

        return $logger;
    }
}
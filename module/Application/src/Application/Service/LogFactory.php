<?php

namespace Application\Service;

use Zend\Log\Logger;
use Zend\Log\LoggerInterface;
use Zend\Log\Writer\Stream;
use Zend\Log\Writer\WriterInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LogFactory implements FactoryInterface
{
    /** @var WriterInterface */
    private $writer;

    /**
     * @param WriterInterface $writer
     * @return LogFactory
     */
    public function setWriter(WriterInterface $writer)
    {
        $this->writer = $writer;
        return $this;
    }

    /**
     * @return WriterInterface
     */
    public function getWriter()
    {
        if (!$this->writer instanceof WriterInterface) {
            $this->setWriter(
                new Stream('./data/logs/error_' . date('Y-m') . '.log')
            );
        }
        return $this->writer;
    }

    /**
     * {@inheritdoc}
     * @return LoggerInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $logger = new Logger;
        $logger->addWriter($this->getWriter());

        return $logger;
    }
}

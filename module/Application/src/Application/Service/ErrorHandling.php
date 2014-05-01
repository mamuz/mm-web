<?php

namespace Application\Service;

use Application\Service\Feature\ExceptionLoggerInterface;
use Zend\Log\LoggerInterface;

class ErrorHandling implements ExceptionLoggerInterface
{
    /** @var LoggerInterface */
    private $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function logException(\Exception $e)
    {
        $messages = array();
        $trace = $e->getTraceAsString();
        $i = 1;
        do {
            $messages[] = '#' . $i++ . " " . get_class($e)
                . ' in ' . $e->getFile() . '(' . $e->getLine() . ') ' . $e->getMessage();
        } while ($e = $e->getPrevious());

        $log = "Exception:" . PHP_EOL . implode(PHP_EOL, $messages) . PHP_EOL;
        $log .= "Trace:" . PHP_EOL . $trace;

        $this->logger->err($log);
    }
}

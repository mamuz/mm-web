<?php

namespace Application\Service;

use Zend\Log\LoggerInterface;

class ErrorHandling
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

    /**
     * @param \Exception $e
     * @return ErrorHandling
     */
    public function logException(\Exception $e)
    {
        $trace = $e->getTraceAsString();
        $i = 1;
        do {
            $messages[] = '#' . $i++ . " " . get_class($e)
                . ' in ' . $e->getFile() . '(' . $e->getLine() . ') ' . $e->getMessage();
        } while ($e = $e->getPrevious());

        $log = "Exception:" . PHP_EOL . implode(PHP_EOL, $messages) . PHP_EOL;
        $log .= "Trace:" . PHP_EOL . $trace;

        $this->logger->err($log);

        return $this;
    }
}

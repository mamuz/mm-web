<?php

namespace MamuzApplication\Service;

use MamuzApplication\Service\Feature\ExceptionLoggerInterface;
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
        $log = $this->buildMessageBy($e) . PHP_EOL . $e->getTraceAsString();
        $this->logger->err($log);

        return $this;
    }

    /**
     * @param \Exception $e
     * @return string
     */
    private function buildMessageBy(\Exception $e)
    {
        $messages = array();

        $i = 1;
        do {
            $messages[] = sprintf(
                '#%d %s in %s (%d): %s',
                $i++,
                get_class($e),
                $e->getFile(),
                $e->getLine(),
                $e->getMessage()
            );
        } while ($e = $e->getPrevious());

        return implode(PHP_EOL, $messages);
    }
}

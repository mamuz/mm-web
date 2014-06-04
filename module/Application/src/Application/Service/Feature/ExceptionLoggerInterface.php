<?php

namespace Application\Service\Feature;

interface ExceptionLoggerInterface
{
    /**
     * @param \Exception $e
     * @return ExceptionLoggerInterface
     */
    public function logException(\Exception $e);
}

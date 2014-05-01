<?php

namespace Application\Service\Feature;

interface ExceptionLoggerInterface
{
    /**
     * @param \Exception $e
     * @return void
     */
    public function logException(\Exception $e);
}

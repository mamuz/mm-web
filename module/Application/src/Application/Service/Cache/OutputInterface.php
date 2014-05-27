<?php

namespace Application\Service\Cache;

use Zend\Http\PhpEnvironment\Response as HttpResponse;
use Zend\Mvc\MvcEvent;

interface OutputInterface
{
    /**
     * @param MvcEvent $event
     * @return OutputInterface
     */
    public function bindMvcEvent(MvcEvent $event);

    /**
     * @return null|HttpResponse
     */
    public function read();

    /**
     * @return OutputInterface
     */
    public function write();
}

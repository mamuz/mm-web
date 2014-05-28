<?php

namespace Application\Service\Feature;

use Zend\Http\PhpEnvironment\Response as HttpResponse;
use Zend\Mvc\MvcEvent;

interface OutputCacheInterface
{
    /**
     * @param MvcEvent $event
     * @return OutputCacheInterface
     */
    public function bindMvcEvent(MvcEvent $event);

    /**
     * @return null|HttpResponse
     */
    public function read();

    /**
     * @return OutputCacheInterface
     */
    public function write();
}

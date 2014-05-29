<?php

namespace MamuzApplication\Service;

use MamuzApplication\Service\Feature\OutputCacheInterface;
use Zend\Cache\Storage\StorageInterface;
use Zend\Http\PhpEnvironment\Request as HttpRequest;
use Zend\Http\PhpEnvironment\Response as HttpResponse;
use Zend\Mvc\MvcEvent;

class OutputCache implements OutputCacheInterface
{
    const HEADER_FIELD_NAME = 'X-MamuzApplication-Cache';

    /** @var StorageInterface */
    private $storage;

    /** @var string */
    private $key;

    /** @var bool */
    private $isWritable = false;

    /** @var HttpRequest */
    private $request;

    /** @var HttpResponse */
    private $response;

    /** @var array */
    private $blacklistedRouteNames = array();

    /**
     * @param StorageInterface $storage
     */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param array $blacklistedRouteNames
     * @return OutputCache
     */
    public function setBlacklistedRouteNames(array $blacklistedRouteNames)
    {
        $this->blacklistedRouteNames = $blacklistedRouteNames;
        return $this;
    }

    /**
     * @param $routeName
     * @return bool
     */
    private function blacklistedRouteNamesMatchWith($routeName)
    {
        return in_array($routeName, $this->blacklistedRouteNames);
    }

    public function bindMvcEvent(MvcEvent $event)
    {
        $this->resetKey();

        if (!$event->getRequest() instanceof HttpRequest) {
            return $this;
        }

        if ($routeMatch = $event->getRouteMatch()) {
            if ($this->blacklistedRouteNamesMatchWith($routeMatch->getMatchedRouteName())) {
                return $this;
            }
        }

        $this->request = $event->getRequest();
        $this->response = $event->getResponse();
        $this->hashKey();

        return $this;
    }

    /**
     * @return void
     */
    private function resetKey()
    {
        $this->key = null;
    }

    /**
     * @return void
     */
    private function hashKey()
    {
        $this->key = md5(rtrim($this->request->getRequestUri(), '/'));
    }

    /**
     * @return bool
     */
    private function hasKey()
    {
        return is_string($this->key);
    }

    public function read()
    {
        if (!$this->hasKey()) {
            return null;
        }

        if ($result = $this->storage->getItem($this->key)) {
            $this->response->setContent($result);
            $this->response->getHeaders()->addHeaderLine(self::HEADER_FIELD_NAME, $this->key);
            $this->isWritable = false;
            return $this->response;
        } else {
            $this->isWritable = true;
            return null;
        }
    }

    public function write()
    {
        if ($this->hasKey() && $this->isWritable) {
            $this->storage->setItem($this->key, $this->response->getContent());
        }

        return $this;
    }
}

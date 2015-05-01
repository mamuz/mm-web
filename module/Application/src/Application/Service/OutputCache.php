<?php

namespace Application\Service;

use Application\Service\Feature\OutputCacheInterface;
use Zend\Cache\Storage\StorageInterface;
use Zend\Http\PhpEnvironment\Request as HttpRequest;
use Zend\Http\PhpEnvironment\Response as HttpResponse;
use Zend\Mvc\MvcEvent;

class OutputCache implements OutputCacheInterface
{
    const HEADER_FIELD_NAME = 'X-Application-Cache';

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
        $id = rtrim($this->request->getRequestUri(), '/');
        $id .= $this->request->isXmlHttpRequest() ? '__xhr' : '__non-xhr';

        $this->key = md5($id);
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
            $this->response->setStatusCode($result['statusCode']);
            $this->response->getHeaders()->addHeaders($result['headers']);
            $this->response->setContent($result['content']);
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
            $data = array(
                'statusCode' => $this->response->getStatusCode(),
                'headers'    => $this->response->getHeaders()->toArray(),
                'content'    => $this->response->getContent(),
            );
            $this->storage->setItem($this->key, $data);
        }

        return $this;
    }
}

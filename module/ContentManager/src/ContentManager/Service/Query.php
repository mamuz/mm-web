<?php

namespace ContentManager\Service;

use ContentManager\Feature\QueryInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;

class Query implements EventManagerAwareInterface, QueryInterface
{
    use EventManagerAwareTrait;

    /** @var QueryInterface */
    private $mapper;

    /**
     * @param QueryInterface $mapper
     */
    public function __construct(QueryInterface $mapper)
    {
        $this->mapper = $mapper;
    }

    public function findActivePageByPath($path)
    {
        $this->triggerEvent(__FUNCTION__ . '.pre', func_get_args());
        $entity = $this->mapper->findActivePageByPath($path);
        $this->triggerEvent(__FUNCTION__ . '.post', array($entity));

        return $entity;
    }

    /**
     * @param string $name
     * @param array  $argv
     * @return void
     */
    private function triggerEvent($name, array $argv)
    {
        $this->getEventManager()->trigger($name, $this, $argv);
    }
}

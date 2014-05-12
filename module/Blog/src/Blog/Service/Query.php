<?php

namespace Blog\Service;

use Blog\Feature\QueryInterface;
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

    public function setCurrentPage($currentPage)
    {
        $this->mapper->setCurrentPage($currentPage);
        return $this;
    }

    public function findActivePosts()
    {
        $this->triggerEvent(__FUNCTION__ . '.pre', func_get_args());
        $collection = $this->mapper->findActivePosts();
        $this->triggerEvent(__FUNCTION__ . '.post', array($collection));

        return $collection;
    }

    public function findActivePostsByTag($tag)
    {
        $this->triggerEvent(__FUNCTION__ . '.pre', func_get_args());
        $collection = $this->mapper->findActivePostsByTag($tag);
        $this->triggerEvent(__FUNCTION__ . '.post', array($collection));

        return $collection;
    }

    public function findActivePostById($id)
    {
        $this->triggerEvent(__FUNCTION__ . '.pre', func_get_args());
        $entity = $this->mapper->findActivePostById($id);
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

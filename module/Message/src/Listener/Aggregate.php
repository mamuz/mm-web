<?php

namespace Message\Listener;

use Message\Entity;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Stdlib\MessageInterface;

class Aggregate extends AbstractListenerAggregate
{
    /** @var Entity\ListenerCollection */
    private $listenerCollection;

    /**
     * @param Entity\ListenerCollection $listenerCollection
     */
    public function __construct(Entity\ListenerCollection $listenerCollection)
    {
        $this->listenerCollection = $listenerCollection;
    }

    /**
     * @param EventManagerInterface $events
     * @return void
     */
    public function attach(EventManagerInterface $events)
    {
        foreach ($this->listenerCollection as $listener) {
            /** @var Entity\Listener $listener */
            $events->getSharedManager()->attach(
                $listener->getId(),
                $listener->getEvent(),
                'onTrigger'
            );
        }
    }

    /**
     * @param EventInterface $e
     * @return void
     */
    public function onTrigger(EventInterface $e)
    {
        $listener = $this->listenerCollection->get(get_class($e->getTarget()));

        if ($listener->hasFilter()) {
            $message = $listener->getFilter()->filter($e->getParams());
        } else {
            $message = $e->getParam('message');
        }

        if ($message instanceof MessageInterface) {
            $this->messenger->setAdapterOptions($listener->getAdapterOptions());
            $this->messenger->setMessage($message);
            $this->messenger->send();
        }
    }
}

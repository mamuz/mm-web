<?php

namespace Contact\Service;

use Contact\Entity\Contact;
use Contact\Feature\CommandInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;

class Command implements EventManagerAwareInterface, CommandInterface
{
    use EventManagerAwareTrait;

    /** @var CommandInterface */
    private $mapper;

    /**
     * @param CommandInterface $mapper
     */
    public function __construct(CommandInterface $mapper)
    {
        $this->mapper = $mapper;
    }

    public function persist(Contact $contact)
    {
        $this->triggerEvent(__FUNCTION__ . '.pre', func_get_args());
        $this->mapper->persist($contact);
        $this->triggerEvent(__FUNCTION__ . '.post', func_get_args());

        return $contact;
    }

    /**
     * @param string $event
     * @param array  $args
     * @return void
     */
    private function triggerEvent($event, array $args)
    {
        $this->getEventManager()->trigger($event, $this, $args);
    }
}

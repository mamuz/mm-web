<?php

namespace Application\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class Aggregate extends AbstractListenerAggregate implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /**
     * @return \Application\Service\Mail
     */
    private function getMailService()
    {
        return $this->getServiceLocator()->get('Application\Service\Mail');
    }

    /**
     * @param EventManagerInterface $events
     * @return void
     */
    public function attach(EventManagerInterface $events)
    {
        $events->getSharedManager()->attach(
            'Contact\Service\Command',
            'persist.post',
            array($this, 'onPersistContact')
        );
    }

    /**
     * @param EventInterface $e
     * @return void
     */
    public function onPersistContact(EventInterface $e)
    {
        /** @var \Contact\Entity\Contact $contact */
        $contact = $e->getParam(0);
        $this->getMailService()->send(); // @todo with interface
    }
}

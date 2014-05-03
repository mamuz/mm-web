<?php

namespace Application\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\ServiceManager\ServiceLocatorInterface;

class Aggregate extends AbstractListenerAggregate implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

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
        /** @var ServiceLocatorInterface $serviceLocator */
        $serviceLocator = $this->getServiceLocator()->get('Application\PluginManager');
        /** @var \Application\Service\Feature\MailObjectInterface $mailer */
        $mailer = $serviceLocator->get('Application\Service\ContactMail');
        $mailer->bind($e->getParam(0));
        $mailer->send();
    }
}

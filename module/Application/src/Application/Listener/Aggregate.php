<?php

namespace Application\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceLocatorInterface;

class Aggregate extends AbstractListenerAggregate
{
    /** @var ServiceLocatorInterface */
    private $pluginManager;

    /** @var \Application\Service\Cache\OutputInterface */
    private $cache;

    /**
     * @param ServiceLocatorInterface $pluginManager
     */
    public function __construct(ServiceLocatorInterface $pluginManager)
    {
        $this->pluginManager = $pluginManager;
        $this->cache = $this->pluginManager->get('Application\Service\Cache\Output');
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

        $events->attach(MvcEvent::EVENT_ROUTE, array($this, 'onMvcRoute'), -100);
        $events->attach(MvcEvent::EVENT_FINISH, array($this, 'onMvcFinish'), -100);
    }

    /**
     * @param EventInterface $e
     * @return void
     */
    public function onPersistContact(EventInterface $e)
    {
        /** @var \Application\Service\Feature\MailObjectInterface $mailer */
        $mailer = $this->pluginManager->get('Application\Service\ContactMail');
        $mailer->bind($e->getParam(0));
        $mailer->send();
    }

    /**
     * @param MvcEvent $e
     * @return null|\Zend\Http\PhpEnvironment\Response
     */
    public function onMvcRoute(MvcEvent $e)
    {
        return $this->cache->bindMvcEvent($e)->read();
    }

    /**
     * @param MvcEvent $e
     * @return void
     */
    public function onMvcFinish(MvcEvent $e)
    {
        $this->cache->bindMvcEvent($e)->write();
    }
}

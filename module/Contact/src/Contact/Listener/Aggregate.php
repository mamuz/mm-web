<?php

namespace Contact\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Mail\Message;
use Zend\Mail\Transport\Sendmail;

class Aggregate extends AbstractListenerAggregate
{
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
        $message = new Message();
        $message->addTo('muzzi_is@web.de')
            ->addFrom('automail@marco-muths.de')
            ->setSubject('New Contact')
            ->setBody(implode(PHP_EOL, $e->getParams()));

        $transport = new Sendmail;
        $transport->send($message);
    }
}

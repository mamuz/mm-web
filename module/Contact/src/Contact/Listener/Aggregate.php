<?php

namespace Contact\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Mail\Message;
use Zend\Mail\Transport\TransportInterface;

class Aggregate extends AbstractListenerAggregate
{
    /** @var TransportInterface */
    private $mailTransporter;

    /**
     * @param TransportInterface $mailTransporter
     */
    public function __construct(TransportInterface $mailTransporter)
    {
        $this->mailTransporter = $mailTransporter;
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
        $message = new Message();
        $message->addTo('muzzi_is@web.de')
            ->addFrom('automail@marco-muths.de')
            ->setSubject('New Contact: ' . $contact->getId())
            ->setBody(implode(PHP_EOL, $contact->toArray()));

        $this->mailTransporter->send($message);
    }
}

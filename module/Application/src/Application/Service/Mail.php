<?php

namespace Application\Service;

use Zend\Mail\Message;
use Zend\Mail\Transport\TransportInterface;

class Mail
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

    public function send()
    {
        $message = new Message();
        $message->addTo('muzzi_is@web.de')
            ->addFrom('automail@marco-muths.de')
            ->setSubject('New Contact: ' . $contact->getId())
            ->setBody(implode(PHP_EOL, $contact->toArray()));

        $this->mailTransporter->send($message);
    }
}

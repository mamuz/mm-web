<?php

namespace Application\Service;

use Application\Feature\MailInterface;
use Zend\Filter\FilterInterface;
use Zend\Mail\Message;
use Zend\Mail\Transport\TransportInterface;

class Mail implements MailInterface
{
    /** @var TransportInterface */
    private $mailTransporter;

    /** @var FilterInterface */
    private $messageBuilder;

    /** @var Message */
    private $message;

    /**
     * @param FilterInterface    $messageBuilder
     * @param TransportInterface $mailTransporter
     */
    public function __construct(
        FilterInterface $messageBuilder,
        TransportInterface $mailTransporter
    ) {
        $this->messageBuilder = $messageBuilder;
        $this->mailTransporter = $mailTransporter;
        $this->message = new Message;
    }

    public function bind($object)
    {
        $this->message = $this->messageBuilder->filter($object);
    }

    public function send()
    {
        $this->mailTransporter->send($this->message);
    }
}

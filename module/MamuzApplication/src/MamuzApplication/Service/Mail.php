<?php

namespace MamuzApplication\Service;

use MamuzApplication\Service\Feature\MailObjectInterface;
use Zend\Filter\FilterInterface;
use Zend\Mail\Message;
use Zend\Mail\Transport\TransportInterface;

class Mail implements MailObjectInterface
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
        return $this;
    }

    public function send()
    {
        $this->mailTransporter->send($this->message);
    }
}

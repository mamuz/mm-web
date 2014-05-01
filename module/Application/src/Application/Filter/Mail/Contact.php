<?php

namespace Application\Filter\Mail;

use Zend\Filter\FilterInterface;
use Zend\Mail\Message;

class Contact implements FilterInterface
{
    public function filter($value)
    {
        /** @var \Contact\Entity\Contact $value */
        $message = new Message();
        $message->addTo('muzzi_is@web.de')
            ->addFrom('automail@marco-muths.de')
            ->setSubject('New Contact: ' . $value->getId())
            ->setBody(implode(PHP_EOL, $value->toArray()));

        return $message;
    }
}

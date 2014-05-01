<?php

namespace Application\Service;

use Application\Filter\Mail\Contact as MessageBuilder;
use Zend\Mail\Transport\Sendmail;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ContactMailFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @return Mail
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $mailTransporter = new Sendmail;
        $messageBuilder = new MessageBuilder;
        $mailer = new Mail($messageBuilder, $mailTransporter);

        return $mailer;
    }
}

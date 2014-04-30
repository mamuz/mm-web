<?php

namespace Application\Service;

use Zend\Mail\Transport\Sendmail;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LogFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @return Mail
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $mailTransporter = new Sendmail;
        $mailer = new Mail($mailTransporter);

        return $mailer;
    }
}

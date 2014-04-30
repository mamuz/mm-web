<?php

namespace Contact\Listener;

use Zend\Mail\Transport\Sendmail;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AggregateFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @return Aggregate
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $mailTransporter = new Sendmail;
        $aggregate = new Aggregate($mailTransporter);

        return $aggregate;
    }
}

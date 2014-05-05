<?php

namespace Blog\View\Helper;

use Blog\Options\Range;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;

class PagerNextFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @return ServiceLocatorInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if ($serviceLocator instanceof ServiceLocatorAwareInterface) {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }

        $config = $serviceLocator->get('Config')['blog']['pagination'];

        $range = new Range($config['range']);

        return new PagerNext($range);
    }
}

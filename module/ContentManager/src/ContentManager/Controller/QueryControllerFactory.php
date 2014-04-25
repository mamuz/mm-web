<?php

namespace ContentManager\Controller;

use ContentManager\Controller\QueryController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class QueryControllerFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @return QueryController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if ($serviceLocator instanceof ServiceLocatorAwareInterface) {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }

        /** @var \ContentManager\Feature\QueryInterface $queryService */
        $queryService = $serviceLocator->get('ContentManager\Service\Query');

        $controller = new QueryController($queryService);

        return $controller;
    }
}

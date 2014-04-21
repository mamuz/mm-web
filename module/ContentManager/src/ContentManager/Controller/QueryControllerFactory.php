<?php

namespace ContentManager\Controller;

use ContentManager\Controller\QueryController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class QueryControllerFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @return QueryController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Zend\Mvc\Controller\ControllerManager $serviceLocator */
        /** @var \ContentManager\Service\Query $queryService */
        $queryService = $serviceLocator->getServiceLocator()->get('ContentManager\Service\Query');

        $controller = new QueryController($queryService);

        return $controller;
    }
}

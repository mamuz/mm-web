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
        /** @var \ContentManager\Service\Query $queryService */
        $queryService = $serviceLocator->get('ContentManager\Service\Query');

        $controller = new QueryController;
        $controller->setQueryService($queryService);

        return $controller;
    }
}
<?php

namespace Blog\Controller;

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
        /** @var ServiceLocatorInterface $domainManager */
        $domainManager = $serviceLocator->get('Blog\DomainManager');

        /** @var \Blog\Feature\QueryInterface $queryService */
        $queryService = $domainManager->get('Blog\Service\Query');

        /** @var \Blog\Crypt\AdapterInterface $cryptEngine */
        $cryptEngine = $domainManager->get('Blog\Crypt\HashIdAdapter');

        $controller = new QueryController($queryService, $cryptEngine);

        return $controller;
    }
}

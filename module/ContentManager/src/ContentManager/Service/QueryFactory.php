<?php

namespace ContentManager\Mapper;

use ContentManager\Mapper\Db\Query as QueryMapper;
use ContentManager\Service\Query as QueryService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class QueryFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @return QueryService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');

        $queryMapper = new QueryMapper;
        $queryMapper->setEntityManager($entityManager);

        $queryService = new QueryService;
        $queryService->setQueryMapper($queryMapper);

        return $queryService;
    }
}
<?php

namespace ContentManager\Service;

use ContentManager\Filter\PageCriteria;
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

        $criteriaFilter = new PageCriteria;
        $queryMapper = new QueryMapper($entityManager, $criteriaFilter);
        $queryService = new QueryService($queryMapper);

        return $queryService;
    }
}

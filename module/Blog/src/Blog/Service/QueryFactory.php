<?php

namespace Blog\Service;

use Blog\Mapper\Db\Query as QueryMapper;
use Blog\Options\Range;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class QueryFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @return \Blog\Feature\QueryInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Doctrine\ORM\EntityManagerInterface $entityManager */
        $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
        $config = $serviceLocator->get('Config')['blog']['pagination'];

        $queryMapper = new QueryMapper($entityManager, new Range($config['range']));
        $queryService = new Query($queryMapper);

        return $queryService;
    }
}

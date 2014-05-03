<?php

namespace Blog\Service;

use Blog\Mapper\Db\Query as QueryMapper;
use Blog\Service\Query as QueryService;
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
        /** @var \Doctrine\Common\Persistence\ObjectManager $entityManager */
        $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
        $repository = $entityManager->getRepository('Blog\Entity\Blog');

        $queryMapper = new QueryMapper($repository);
        $queryService = new QueryService($queryMapper);

        return $queryService;
    }
}

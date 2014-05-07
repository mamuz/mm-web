<?php

namespace ContentManager\Service;

use ContentManager\Mapper\Db\Query as QueryMapper;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class QueryFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @return \ContentManager\Feature\QueryInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Doctrine\Common\Persistence\ObjectManager $entityManager */
        $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
        $repository = $entityManager->getRepository('ContentManager\Entity\Page');

        $queryMapper = new QueryMapper($repository);
        $queryService = new Query($queryMapper);

        return $queryService;
    }
}

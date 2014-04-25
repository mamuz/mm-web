<?php

namespace Contact\Service;

use Contact\Mapper\Db\Command as CommandMapper;
use Contact\Service\Command as CommandService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CommandFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @return CommandService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Doctrine\Common\Persistence\ObjectManager $entityManager */
        $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');

        $queryMapper = new CommandMapper($entityManager);
        $queryService = new CommandService($queryMapper);

        return $queryService;
    }
}
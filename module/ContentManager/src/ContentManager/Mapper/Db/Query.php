<?php

namespace ContentManager\Mapper\Db;

use ContentManager\Entity\NullPage;
use ContentManager\Feature\QueryInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class Query implements QueryInterface
{
    /** @var EntityManager */
    private $entityManager;

    /**
     * @param EntityManager $entityManager
     * @return Query
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     * @return EntityManager
     * @throws \DomainException
     */
    public function getEntityManager()
    {
        if (!$this->entityManager instanceof EntityManager) {
            throw new \DomainException("EntityManager has not been set");
        }
        return $this->entityManager;
    }

    public function findPageByName($name)
    {
        $page = $this->getRepository()->findOneBy(array('name' => $name));

        if (null === $page) {
            $page = new NullPage;
        }

        return $page;
    }

    /**
     * @return EntityRepository
     */
    protected function getRepository()
    {
        return $this->getEntityManager()->getRepository('ContentManager\Entity\Page');
    }
}

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
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findPageByNode($parent, $child = null)
    {
        $criteria = $this->createCriteria($parent, $child);
        $page = $this->getRepository()->findOneBy($criteria);

        if (null === $page) {
            $page = new NullPage;
        }

        return $page;
    }

    /**
     * @param string      $parent
     * @param string|null $child
     * @return array
     */
    protected function createCriteria($parent, $child = null)
    {
        $criteria = array('active' => true);
        if (null !== $child) {
            $criteria['name'] = $child;
            $criteria['parentName'] = $parent;
        } else {
            $criteria['name'] = $parent;
            $criteria['parentName'] = null;
        }

        return $criteria;
    }

    /**
     * @return EntityRepository
     */
    protected function getRepository()
    {
        return $this->entityManager->getRepository('ContentManager\Entity\Page');
    }
}

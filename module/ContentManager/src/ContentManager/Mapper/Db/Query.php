<?php

namespace ContentManager\Mapper\Db;

use ContentManager\Entity\NullPage;
use ContentManager\Feature\QueryInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Zend\Filter\FilterInterface;

class Query implements QueryInterface
{
    /** @var EntityManager */
    private $entityManager;

    /** @var FilterInterface */
    private $criteriaFilter;

    /**
     * @param EntityManager   $entityManager
     * @param FilterInterface $criteriaFilter
     */
    public function __construct(
        EntityManager $entityManager,
        FilterInterface $criteriaFilter
    ) {
        $this->entityManager = $entityManager;
        $this->criteriaFilter = $criteriaFilter;
    }

    public function findPageByCriteria(array $criteria)
    {
        $criteria = $this->criteriaFilter->filter($criteria);
        $page = $this->getRepository()->findOneBy($criteria);

        if (null === $page) {
            $page = new NullPage;
        }

        return $page;
    }

    /**
     * @return EntityRepository
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('ContentManager\Entity\Page');
    }
}

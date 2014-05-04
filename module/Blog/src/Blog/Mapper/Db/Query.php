<?php

namespace Blog\Mapper\Db;

use Blog\Feature\QueryInterface;
use Blog\Service\Feature\RangeInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

class Query implements QueryInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var RangeInterface */
    private $range;

    /**
     * @param EntityManagerInterface $entityManager
     * @param RangeInterface         $range
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        RangeInterface $range
    ) {
        $this->entityManager = $entityManager;
        $this->range = $range;
    }

    public function findActivePosts($currentPage)
    {
        $firstResult = $this->range->getOffsetBy($currentPage);
        $maxResults = $this->range->getSize();

        $dql = 'SELECT p, t FROM Blog\Entity\Post p LEFT JOIN p.tags t '
            . 'WHERE p.active = 1 '
            . 'ORDER BY p.createdAt DESC';

        $query = $this->createQuery($dql);
        $query->setFirstResult($firstResult)->setMaxResults($maxResults);

        return new Paginator($query);
    }

    private function createQuery($dql)
    {
        return $this->entityManager->createQuery($dql);
    }
}

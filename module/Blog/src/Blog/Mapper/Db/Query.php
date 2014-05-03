<?php

namespace Blog\Mapper\Db;

use Blog\Feature\QueryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

class Query implements QueryInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findCollection(array $criteria)
    {
        $currentPage = 1;
        $pageSize = 4;

        if (isset($criteria['page'])) {
            $currentPage = (int) $criteria['page'];
        }

        $dql = 'SELECT p, t FROM Blog\Entity\Post p LEFT JOIN p.tags t WHERE p.active = 1 ORDER BY p.createdAt DESC';
        $query = $this->entityManager->createQuery($dql);
        $paginator = new Paginator($query);

        // $totalItems = count($paginator);
        // $pagesCount = ceil($totalItems / $pageSize);

        $offset = $pageSize * ($currentPage - 1);
        $paginator->getQuery()->setFirstResult($offset)->setMaxResults($pageSize);

        return $paginator;
    }
}

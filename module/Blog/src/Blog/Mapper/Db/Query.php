<?php

namespace Blog\Mapper\Db;

use Blog\Feature\QueryInterface;
use Blog\Options\Constraint;
use Blog\Options\ConstraintInterface;
use Blog\Options\RangeInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

class Query implements QueryInterface
{
    const REPOSITORY = 'Blog\Entity\Post';

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var RangeInterface */
    private $range;

    /** @var int */
    private $currentPage = 1;

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

    public function setCurrentPage($currentPage)
    {
        $this->currentPage = (int) $currentPage;
        return $this;
    }

    public function findActivePosts()
    {
        $constraint = new Constraint;
        $constraint->add('active', 'p.active = :active', true);

        return $this->createPaginator($constraint);
    }

    public function findActivePostsByTag($tag)
    {
        $constraint = new Constraint;
        $constraint->add('active', 'p.active = :active', 1);
        $constraint->add('tag', 'AND t.name = :tag', $tag);

        return $this->createPaginator($constraint);
    }

    private function createPaginator(ConstraintInterface $constraint)
    {
        $firstResult = $this->range->getOffsetBy($this->currentPage);
        $maxResults = $this->range->getSize();
        $constraintString = '';

        if (!$constraint->isEmpty()) {
            $constraintString = "WHERE " . $constraint->toString() . ' ';
        }

        $dql = 'SELECT p, t FROM ' . self::REPOSITORY . ' p LEFT JOIN p.tags t '
            . $constraintString
            . 'ORDER BY p.createdAt DESC';

        $query = $this->entityManager->createQuery($dql);
        $query->setFirstResult($firstResult)->setMaxResults($maxResults);

        if (!$constraint->isEmpty()) {
            $query->setParameters($constraint->toArray());
        }

        return new Paginator($query);
    }

    public function findActivePostById($id)
    {
        return $this->entityManager->find(self::REPOSITORY, $id);
    }
}

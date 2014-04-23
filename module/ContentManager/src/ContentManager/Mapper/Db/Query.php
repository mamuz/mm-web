<?php

namespace ContentManager\Mapper\Db;

use ContentManager\Entity\NullPage;
use ContentManager\Feature\QueryInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use Zend\Filter\FilterInterface;

class Query implements QueryInterface
{
    /** @var ObjectRepository */
    private $repository;

    /** @var FilterInterface */
    private $criteriaFilter;

    /**
     * @param ObjectRepository $repository
     * @param FilterInterface  $criteriaFilter
     */
    public function __construct(
        ObjectRepository $repository,
        FilterInterface $criteriaFilter
    ) {
        $this->repository = $repository;
        $this->criteriaFilter = $criteriaFilter;
    }

    public function findPageByCriteria(array $criteria)
    {
        $criteria = $this->criteriaFilter->filter($criteria);
        $page = $this->repository->findOneBy($criteria);

        if (null === $page) {
            $page = new NullPage;
        }

        return $page;
    }
}

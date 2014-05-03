<?php

namespace Blog\Mapper\Db;

use Blog\Feature\QueryInterface;
use Doctrine\Common\Persistence\ObjectRepository;

class Query implements QueryInterface
{
    /** @var ObjectRepository */
    private $repository;

    /**
     * @param ObjectRepository $repository
     */
    public function __construct(ObjectRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findCollection(array $criteria)
    {
        $blogCollection = $this->repository->findBy($criteria);
        return $blogCollection;
    }
}

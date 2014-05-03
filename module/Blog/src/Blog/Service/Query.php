<?php

namespace Blog\Service;

use Blog\Feature\QueryInterface;

class Query implements QueryInterface
{
    /** @var QueryInterface */
    private $mapper;

    /**
     * @param QueryInterface $mapper
     */
    public function __construct(QueryInterface $mapper)
    {
        $this->mapper = $mapper;
    }

    public function findCollection(array $criteria)
    {
        return $this->mapper->findCollection($criteria);
    }
}

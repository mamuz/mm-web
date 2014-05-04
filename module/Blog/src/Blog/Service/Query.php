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

    public function findActivePosts($currentPage)
    {
        return $this->mapper->findActivePosts($currentPage);
    }
}

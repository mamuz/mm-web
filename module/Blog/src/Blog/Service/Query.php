<?php

namespace Blog\Service;

use ContentManager\Feature\QueryInterface;

class Blog implements QueryInterface
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

    public function findLatest()
    {
        return $this->mapper->findLatest();
    }
}

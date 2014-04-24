<?php

namespace ContentManager\Service;

use ContentManager\Feature\QueryInterface;

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

    public function findActivePageByPath($path)
    {
        return $this->mapper->findActivePageByPath($path);
    }
}

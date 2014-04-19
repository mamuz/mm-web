<?php

namespace ContentManager\Mapper;

use ContentManager\Feature\QueryInterface;

trait QueryAwareTrait
{
    /** @var QueryInterface */
    private $queryMapper;

    /**
     * @param QueryInterface $queryMapper
     * @return object
     */
    public function setQueryMapper(QueryInterface $queryMapper)
    {
        $this->queryMapper = $queryMapper;
        return $this;
    }

    /**
     * @return QueryInterface
     * @throws \DomainException
     */
    public function getQueryMapper()
    {
        if (!$this->queryMapper instanceof QueryInterface) {
            throw new \DomainException("QueryMapper has not been set");
        }
        return $this->queryMapper;
    }
}

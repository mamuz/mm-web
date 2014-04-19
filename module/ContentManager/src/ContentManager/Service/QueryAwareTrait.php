<?php

namespace ContentManager\Service;

use ContentManager\Feature\QueryInterface;

trait QueryAwareTrait
{
    /** @var QueryInterface */
    private $queryService;

    /**
     * @param QueryInterface $queryService
     * @return object
     */
    public function setQueryService(QueryInterface $queryService)
    {
        $this->queryService = $queryService;
        return $this;
    }

    /**
     * @return QueryInterface
     * @throws \DomainException
     */
    public function getQueryService()
    {
        if (!$this->queryService instanceof QueryInterface) {
            throw new \DomainException("QueryService has not been set");
        }
        return $this->queryService;
    }
}

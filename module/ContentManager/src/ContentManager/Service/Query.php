<?php

namespace ContentManager\Service;

use ContentManager\Feature\QueryInterface;
use ContentManager\Mapper\QueryAwareTrait;

class Query implements QueryInterface
{
    use QueryAwareTrait;

    public function findPageByName($name)
    {
        return $this->getQueryMapper()->findPageByName($name);
    }
}

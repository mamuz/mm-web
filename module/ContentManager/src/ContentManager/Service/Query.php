<?php

namespace ContentManager\Service;

use ContentManager\Feature\QueryInterface;
use ContentManager\Mapper\QueryAwareTrait;

class Query implements QueryInterface
{
    use QueryAwareTrait;

    public function findPageByNode($parent, $child = null)
    {
        return $this->getQueryMapper()->findPageByNode($parent, $child);
    }
}

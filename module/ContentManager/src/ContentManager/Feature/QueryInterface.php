<?php

namespace ContentManager\Feature;

use ContentManager\Entity\Page;

interface QueryInterface
{
    /**
     * @param array $criteria
     * @return Page
     */
    public function findPageByCriteria(array $criteria);
}

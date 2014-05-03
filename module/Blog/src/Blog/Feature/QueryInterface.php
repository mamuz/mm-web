<?php

namespace Blog\Feature;

use Blog\Entity\Blog;

interface QueryInterface
{
    /**
     * @param array $criteria
     * @return Blog[]
     */
    public function findCollection(array $criteria);
}

<?php

namespace Blog\Feature;

use Blog\Entity\Post;

interface QueryInterface
{
    /**
     * @param array $criteria
     * @return Post[]
     */
    public function findCollection(array $criteria);
}

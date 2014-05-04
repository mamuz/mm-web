<?php

namespace Blog\Feature;

use Blog\Entity\Post;

interface QueryInterface
{
    /**
     * @param int $currentPage
     * @return Post[]
     */
    public function findActivePosts($currentPage);
}

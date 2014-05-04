<?php

namespace Blog\Feature;

use Blog\Entity\Post;

interface QueryInterface
{
    /**
     * @param int         $currentPage
     * @param string|null $tag
     * @return Post[]
     */
    public function findActivePosts($currentPage, $tag = null);
}

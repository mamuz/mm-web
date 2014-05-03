<?php

namespace Blog\Feature;

use Blog\Entity\Blog;

interface QueryInterface
{
    /**
     * @return Blog[]
     */
    public function findLatest();
}

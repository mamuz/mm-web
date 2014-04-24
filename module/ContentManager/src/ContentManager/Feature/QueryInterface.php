<?php

namespace ContentManager\Feature;

use ContentManager\Entity\Page;

interface QueryInterface
{
    /**
     * @param string $path
     * @return Page
     */
    public function findActivePageByPath($path);
}

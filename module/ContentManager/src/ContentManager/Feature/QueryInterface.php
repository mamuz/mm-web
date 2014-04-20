<?php

namespace ContentManager\Feature;

use ContentManager\Entity\Page;

interface QueryInterface
{
    /**
     * @param string      $parent
     * @param string|null $child
     *
     * @return Page
     */
    public function findPageByNode($parent, $child = null);
}
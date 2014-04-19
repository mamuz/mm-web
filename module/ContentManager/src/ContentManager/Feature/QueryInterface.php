<?php

namespace ContentManager\Feature;

use ContentManager\Entity\Page;

interface QueryInterface
{
    /**
     * @param string $name
     * @return Page
     */
    public function findPageByName($name);
}
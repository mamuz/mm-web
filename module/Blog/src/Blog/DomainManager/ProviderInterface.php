<?php

namespace Blog\DomainManager;

interface ProviderInterface
{
    /**
     * @return array
     */
    public function getBlogDomainConfig();
}

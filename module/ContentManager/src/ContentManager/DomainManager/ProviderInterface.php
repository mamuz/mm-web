<?php

namespace ContentManager\DomainManager;

interface ProviderInterface
{
    /**
     * @return array
     */
    public function getContentManagerDomainConfig();
}

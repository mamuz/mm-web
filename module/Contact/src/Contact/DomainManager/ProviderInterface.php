<?php

namespace Contact\DomainManager;

interface ProviderInterface
{
    /**
     * @return array
     */
    public function getContactDomainConfig();
}

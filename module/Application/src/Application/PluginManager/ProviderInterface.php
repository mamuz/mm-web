<?php

namespace Application\PluginManager;

interface ProviderInterface
{
    /**
     * @return array
     */
    public function getApplicationPluginConfig();
}

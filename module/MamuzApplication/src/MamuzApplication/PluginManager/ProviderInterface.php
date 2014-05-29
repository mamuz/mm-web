<?php

namespace MamuzApplication\PluginManager;

interface ProviderInterface
{
    /**
     * @return array
     */
    public function getApplicationPluginConfig();
}

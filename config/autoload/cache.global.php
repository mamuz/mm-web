<?php

return array(
    'caches' => array(
        'outputCache' => array(
            'adapter'               => array(
                'name' => 'filesystem'
            ),
            'options'               => array(
                'cache_dir' => './data/cache/output',
            ),
            'blacklistedRouteNames' => array(
                'contact',
                'blogFeedPosts',
            ),
        ),
    ),
);

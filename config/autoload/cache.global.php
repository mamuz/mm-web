<?php

return array(
    'caches' => array(
        'outputCache' => array(
            'adapter'               => array(
                'name' => 'filesystem',
            ),
            'options'               => array(
                'cache_dir' => './data/cache/output',
            ),
            'plugins'               => array(
                'serializer',
                'exception_handler' => array(
                    'throw_exceptions' => false,
                ),
                'ignore_user_abort' => array(
                    'exit_on_abort' => false,
                ),
            ),
            'blacklistedRouteNames' => array(
                'contact',
            ),
        ),
    ),
);

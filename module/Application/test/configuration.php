<?php

// Define environment
$env = getenv('APPLICATION_ENV') ? : 'production';

return array(
    'modules'                 => array(
        'Application',
    ),
    'module_listener_options' => array(
        'config_glob_paths' => array(
            sprintf('config/autoload/{,*.}{global,%s,local}.php', $env),
        ),
        'module_paths'      => array(
            'module',
            'vendor',
        ),
    ),
);

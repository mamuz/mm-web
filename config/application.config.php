<?php

// Define environment
$env = getenv('APPLICATION_ENV') ? : 'production';

$modules = array(
    'DoctrineModule',
    'DoctrineORMModule',
    'Application',
    'ContentManager',
);

return array(
    'modules'                 => $modules,
    'module_listener_options' => array(
        'module_paths'             => array(
            './module',
            './vendor',
        ),
        'config_glob_paths'        => array(
            sprintf('config/autoload/{,*.}{global,%s,local}.php', $env),
        ),
        'config_cache_enabled'     => ($env == 'production'),
        'config_cache_key'         => 'app_config',
        'module_map_cache_enabled' => ($env == 'production'),
        'module_map_cache_key'     => 'module_map',
        'cache_dir'                => __DIR__ . '/../data/cache/',
        'check_dependencies'       => ($env != 'production'),
    ),
);

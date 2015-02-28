<?php

$env = getenv('APPLICATION_ENV') ? : 'production';

$devModules = array(
    'ZendDeveloperTools',
);

$modules = array(
    'Application',
);

return array(
    'modules'                 => ($env == 'development') ? array_merge($devModules, $modules) : $modules,
    'module_listener_options' => array(
        'module_paths'             => array('./module', './vendor'),
        'config_glob_paths'        => array(
            sprintf('config/autoload/{,*.}{global,%s,local}.php', $env),
        ),
        'config_cache_enabled'     => ($env == 'production'),
        'config_cache_key'         => 'app_config',
        'module_map_cache_enabled' => ($env == 'production'),
        'module_map_cache_key'     => 'module_map',
        'cache_dir'                => __DIR__ . '/../data/cache/config',
        'check_dependencies'       => ($env != 'production'),
    ),
);

<?php

$env = getenv('APPLICATION_ENV') ? : 'production';

return array(
    'router'             => array(
        'routes' => array(
            'home' => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'MamuzApplication\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'controllers'        => array(
        'invokables' => array(
            'MamuzApplication\Controller\Index' => 'MamuzApplication\Controller\IndexController',
        ),
    ),
    'service_manager'    => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
        ),
        'factories'          => array(
            'MamuzApplication\PluginManager'           => 'MamuzApplication\PluginManager\Factory',
            'MamuzApplication\Navigation\Default'      => 'MamuzApplication\Navigation\DefaultFactory',
            'MamuzApplication\Navigation\ProductOwner' => 'MamuzApplication\Navigation\ProductOwnerFactory',
        ),
    ),
    'application_plugin' => array(
        'initializers' => array(
            'ServiceLocatorInitializer' => 'MamuzApplication\PluginManager\ServiceLocatorInitializer',
        ),
        'factories'    => array(
            'MamuzApplication\Service\ContactMail'   => 'MamuzApplication\Service\ContactMailFactory',
            'MamuzApplication\Service\ErrorHandling' => 'MamuzApplication\Service\ErrorHandlingFactory',
            'MamuzApplication\Service\Log'           => 'MamuzApplication\Service\LogFactory',
            'MamuzApplication\Service\OutputCache'   => 'MamuzApplication\Service\OutputCacheFactory',
            'MamuzApplication\Listener\Aggregate'    => 'MamuzApplication\Listener\AggregateFactory',
        ),
    ),
    'view_helpers'       => array(
        'invokables' => array(
            'navItem' => 'MamuzApplication\View\Helper\Navigation\Item',
        ),
        'factories'  => array(
            'autoVersion' => 'MamuzApplication\View\Helper\AutoVersionFactory',
        ),
    ),
    'view_manager'       => array(
        'display_not_found_reason' => ($env != 'production'),
        'display_exceptions'       => ($env != 'production'),
        'doctype'                  => 'HTML5',
        'layout'                   => 'mamuz-layout/layout',
        'not_found_template'       => 'mamuz-error/404',
        'exception_template'       => 'mamuz-error/index',
        'template_map'             => include __DIR__ . '/../template_map.php',
        'template_path_stack'      => array(__DIR__ . '/../view'),
    ),
);

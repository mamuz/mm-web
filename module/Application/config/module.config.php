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
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'controllers'        => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController',
        ),
    ),
    'service_manager'    => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
        ),
        'factories'          => array(
            'Application\PluginManager'      => 'Application\PluginManager\Factory',
            'Application\Navigation\Default' => 'Application\Navigation\DefaultFactory',
        ),
    ),
    'application_plugin' => array(
        'initializers' => array(
            'ServiceLocatorInitializer' => 'Application\PluginManager\ServiceLocatorInitializer',
        ),
        'factories'    => array(
            'Application\Service\ContactMail'   => 'Application\Service\ContactMailFactory',
            'Application\Service\ErrorHandling' => 'Application\Service\ErrorHandlingFactory',
            'Application\Service\Log'           => 'Application\Service\LogFactory',
            'Application\Service\OutputCache'   => 'Application\Service\OutputCacheFactory',
            'Application\Listener\Aggregate'    => 'Application\Listener\AggregateFactory',
        ),
    ),
    'view_helpers'       => array(
        'invokables' => array(
            'navItem'       => 'Application\View\Helper\Navigation\Item',
            'postPanel'     => 'Application\View\Helper\PostPanel',
            'postMeta'      => 'Application\View\Helper\PostMeta',
            'permaLinkTag'  => 'Application\View\Helper\PermaLinkTag',
            'permaLinkPost' => 'Application\View\Helper\PermaLinkPost',
        ),
        'factories'  => array(
            'autoVersion' => 'Application\View\Helper\AutoVersionFactory',
        ),
    ),
    'view_manager'       => array(
        'display_not_found_reason' => ($env != 'production'),
        'display_exceptions'       => ($env != 'production'),
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map'             => include __DIR__ . '/../template_map.php',
        'template_path_stack'      => array(__DIR__ . '/../view'),
    ),
);

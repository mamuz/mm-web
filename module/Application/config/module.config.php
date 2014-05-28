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
            'Application\PluginManager'           => 'Application\PluginManager\Factory',
            'Application\Navigation\Default'      => 'Application\Navigation\DefaultFactory',
            'Application\Navigation\ProductOwner' => 'Application\Navigation\ProductOwnerFactory',
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
            'navItem' => 'Application\View\Helper\Navigation\Item',
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
    ),
    'application'        => array(
        'document_root' => $_SERVER['DOCUMENT_ROOT'],
        'http'          => array(
            'headers' => array(
                'Content-Type'     => 'text/html; charset=UTF-8',
                'Content-Language' => 'en',
            ),
        ),
        'mail'          => array(
            'contact' => array(
                'template_map' => array(
                    'contact/subject' => __DIR__ . '/../view/mail/contact/subject.phtml',
                    'contact/body'    => __DIR__ . '/../view/mail/contact/body.phtml',
                ),
                'options'      => array(
                    'to'              => 'muzzi_is@web.de',
                    'from'            => 'automail@marco-muths.de',
                    'subjectTemplate' => 'contact/subject',
                    'bodyTemplate'    => 'contact/body',
                ),
            ),
        ),
        'log'           => array(
            'exceptionhandler'             => true,
            'errorhandler'                 => true,
            'fatal_error_shutdownfunction' => true,
            'writers'                      => array(
                'error' => array(
                    'name'    => 'stream',
                    'options' => array(
                        'stream'    => './data/logs/error_' . date('Y-m') . '.log',
                        'formatter' => array(
                            'name'    => 'simple',
                            'options' => array(
                                'dateTimeFormat' => 'Y-m-d H:i:s'
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'caches'             => array(
        'outputCache' => array(
            'adapter'               => array(
                'name' => 'filesystem'
            ),
            'options'               => array(
                'cache_dir' => './data/cache/output',
            ),
            'blacklistedRouteNames' => array(
                'contact'
            ),
        ),
    ),
);

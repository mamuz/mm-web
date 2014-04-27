<?php

$env = getenv('APPLICATION_ENV') ? : 'production';

return array(
    'router'          => array(
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
    'controllers'     => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Application\Service\ErrorHandling' => 'Application\Service\ErrorHandlingFactory',
            'Application\Service\Log'           => 'Application\Service\LogFactory',
        ),
    ),
    'view_manager'    => array(
        'display_not_found_reason' => ($env != 'production'),
        'display_exceptions'       => ($env != 'production'),
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map'             => array(
            'plugin/googleanalytics'  => __DIR__ . '/../view/plugin/googleanalytics.phtml',
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'layout/header'           => __DIR__ . '/../view/layout/header.phtml',
            'layout/footer'           => __DIR__ . '/../view/layout/footer.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
    ),
    'application'     => array(
        'http' => array(
            'headers' => array(
                'Content-Type'     => 'text/html; charset=UTF-8',
                'Content-Language' => 'en',
            ),
        ),
    ),
);

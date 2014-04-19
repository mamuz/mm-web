<?php

return array(
    'router'       => array(
        'routes' => array(
            'content' => array(
                'type'          => 'segment',
                'options'       => array(
                    'route'       => '/content[/:name]',
                    'constraints' => array(
                        'name' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults'    => array(
                        'controller' => 'ContentManager\Controller\Query',
                        'action'     => 'page',
                    ),
                ),
                'may_terminate' => true,
            ),
        ),
    ),
    'controllers'  => array(
        'factories' => array(
            'ContentManager\Controller\Query' => 'ContentManager\Controller\QueryControllerFactory'
        ),
    ),
    'service_manager'  => array(
        'factories' => array(
            'ContentManager\Service\Query' => 'ContentManager\Service\QueryFactory'
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'doctrine'     => array(
        'driver' => array(
            'application_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/ContentManager/Entity')
            ),
            'orm_default'          => array(
                'drivers' => array(
                    'ContentManager\Entity' => 'contentmanager_entities'
                ),
            ),
        ),
    ),
);

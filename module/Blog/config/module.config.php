<?php

return array(
    'router'          => array(
        'routes' => array(
            'blogList' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'       => '/blog[/:page]',
                    'constraints' => array(
                        'page' => '[1-9][0-9]*',
                    ),
                    'defaults'    => array(
                        'controller' => 'Blog\Controller\Query',
                        'action'     => 'list',
                        'page'       => 1,
                    ),
                ),
            ),
        ),
    ),
    'controllers'     => array(
        'factories' => array(
            'Blog\Controller\Query' => 'Blog\Controller\QueryControllerFactory'
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Blog\DomainManager' => 'Blog\DomainManager\Factory',
        ),
    ),
    'blog_domain'     => array(
        'factories' => array(
            'Blog\Service\Query' => 'Blog\Service\QueryFactory',
        ),
    ),
    'view_manager'    => array(
        'template_map' => array(
            'blog/query/list' => __DIR__ . '/../view/blog/query/list.phtml',
        ),
    ),
    'doctrine'        => array(
        'driver' => array(
            'blog_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Blog/Entity')
            ),
            'orm_default'   => array(
                'drivers' => array(
                    'Blog\Entity' => 'blog_entities'
                ),
            ),
        ),
    ),
);

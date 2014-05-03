<?php

return array(
    'router'          => array(
        'routes' => array(
            'blog' => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/blog',
                    'defaults' => array(
                        'controller' => 'Blog\Controller\Query',
                        'action'     => 'latest',
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
            'blog/query/latest' => __DIR__ . '/../view/blog/query/latest.phtml',
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

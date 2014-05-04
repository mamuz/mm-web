<?php

return array(
    'router'          => array(
        'routes' => array(
            'blogActivePosts' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'       => '/blog[/:tag][/p/:page]',
                    'constraints' => array(
                        'tag'  => '[a-zA-Z0-9_-]*',
                        'page' => '[1-9][0-9]*',
                    ),
                    'defaults'    => array(
                        'controller' => 'Blog\Controller\Query',
                        'action'     => 'activePosts',
                        'page'       => 1,
                    ),
                ),
            ),
            'blogActivePost'  => array(
                'type'    => 'segment',
                'options' => array(
                    'route'       => '/blog/post[/:title][/h/:id]',
                    'constraints' => array(
                        'title' => '[a-zA-Z0-9_+%-]+',
                        'id'    => '[a-zA-Z0-9]{9,}',
                    ),
                    'defaults'    => array(
                        'controller' => 'Blog\Controller\Query',
                        'action'     => 'activePost',
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
            'Blog\Crypt\HashId'  => 'Blog\Crypt\HashIdFactory',
            'Blog\Service\Query' => 'Blog\Service\QueryFactory',
        ),
    ),
    'view_helpers'    => array(
        'factories' => array(
            'hashId' => 'Blog\View\Helper\HashIdFactory',
        ),
    ),
    'view_manager'    => array(
        'template_map' => array(
            'blog/query/active-post'  => __DIR__ . '/../view/blog/query/active-post.phtml',
            'blog/query/active-posts' => __DIR__ . '/../view/blog/query/active-posts.phtml',
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

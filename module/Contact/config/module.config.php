<?php

return array(
    'router'          => array(
        'routes' => array(
            'contact' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/contact[/]',
                    'defaults' => array(
                        'controller' => 'Contact\Controller\Command',
                        'action'     => 'create',
                    ),
                ),
            ),
        ),
    ),
    'controllers'     => array(
        'factories' => array(
            'Contact\Controller\Command' => 'Contact\Controller\CommandControllerFactory'
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Contact\DomainManager' => 'Contact\DomainManager\Factory',
        ),
    ),
    'contact_domain'  => array(
        'factories' => array(
            'Contact\Service\Command' => 'Contact\Service\CommandFactory',
        ),
    ),
    'form_elements'   => array(
        'factories' => array(
            'Contact\Form\Create' => 'Contact\Form\CreateFactory',
        ),
    ),
    'view_manager'    => array(
        'template_map' => include __DIR__ . '/../template_map.php',
    ),
    'doctrine'        => array(
        'driver' => array(
            'contact_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Contact/Entity')
            ),
            'orm_default'      => array(
                'drivers' => array(
                    'Contact\Entity' => 'contact_entities'
                ),
            ),
        ),
    ),
);

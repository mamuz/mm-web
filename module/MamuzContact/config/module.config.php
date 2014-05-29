<?php

return array(
    'router'          => array(
        'routes' => array(
            'contact' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/contact[/]',
                    'defaults' => array(
                        'controller' => 'MamuzContact\Controller\Command',
                        'action'     => 'create',
                    ),
                ),
            ),
        ),
    ),
    'controllers'     => array(
        'factories' => array(
            'MamuzContact\Controller\Command' => 'MamuzContact\Controller\CommandControllerFactory'
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'MamuzContact\DomainManager' => 'MamuzContact\DomainManager\Factory',
        ),
    ),
    'contact_domain'  => array(
        'factories' => array(
            'MamuzContact\Service\Command' => 'MamuzContact\Service\CommandFactory',
        ),
    ),
    'form_elements'   => array(
        'factories' => array(
            'MamuzContact\Form\Create' => 'MamuzContact\Form\CreateFactory',
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
                'paths' => array(__DIR__ . '/../src/MamuzContact/Entity')
            ),
            'orm_default'      => array(
                'drivers' => array(
                    'MamuzContact\Entity' => 'contact_entities'
                ),
            ),
        ),
    ),
);

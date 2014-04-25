<?php

return array(
    'router'       => array(
        'routes' => array(
            'contact' => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/contact',
                    'defaults' => array(
                        'controller' => 'Contact\Controller\Command',
                        'action'     => 'create',
                    ),
                ),
            ),
        ),
    ),
    'controllers'  => array(
        'factories' => array(
            'Contact\Controller\Command' => 'Contact\Controller\CommanfControllerFactory'
        ),
    ),
    'view_manager' => array(
        'template_map'        => array(
            'contact/command/create' => __DIR__ . '/../view/contact/command/create.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
